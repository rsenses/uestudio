<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Cocur\Slugify\Slugify;
use JasonGrimes\Paginator;
use Kunststube\CSRFP\SignatureGenerator;
use Joelvardy\Flash;
use Flight;
use Respect\Validation\Validator as v;
use Expomark\Validation\Validator;
use Expomark\Upload\AuthorImage;

class AuthorController
{
    private $image;
    private $slugify;
    private $signer;
    private $validator;

    public function __construct()
    {
        Flight::db();
        Flight::eloquent();
        if (!Sentry::check()) {
            Flight::redirect('/author/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }

        $this->image = new AuthorImage();
        $this->validator = new Validator();
        $this->slugify = new Slugify();
        $this->signer = new SignatureGenerator($GLOBALS['config']['info']['secret_word']);
    }

    public function indexAction($page = null)
    {
        // Datos necesarios para el paginador
        $page = $page ?: 1;
        $itemsPerPage = 20;
        $urlPattern = '/users/(:num)';

        //realizamos la consulta de todos los items
        $authors = ORM::for_table('author')
            ->order_by_asc('name')
            ->limit($itemsPerPage)
            ->offset(($page - 1) * $itemsPerPage)
            ->find_many();

        $totalItems = ORM::for_table('users')
            ->count();

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'authors.phtml',
            array(
                'section' => 'author',
                'paginator' => new Paginator($totalItems, $itemsPerPage, $page, $urlPattern),
                'authors' => $authors,
            )
        );
    }

    public function editAction($id = null, $author = null)
    {
        if ($id) {
            $author = ORM::for_table('author')
                ->where('author_id', $id)
                ->find_one();
        }

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'editauthor.phtml',
            array(
                'section' => 'author',
                'author' => $author,
                'id' => $id,
            )
        );
    }

    public function searchAction()
    {
        $searchTerm = Flight::request()->query['term'];
        if (empty($searchTerm)) {
            Flight::notFound();
            die;
        }

        $content = ORM::for_table('author')
            ->where_raw('MATCH(name) AGAINST (?)', array($searchTerm))
            ->order_by_asc('name')
            ->find_many();

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'users.phtml',
            array(
                'section' => 'users',
                'searchTerm' => $searchTerm,
                'paginator' => null,
                'content' => $content,
            )
        );
    }

    public function saveAction($id)
    {
        $validationArray = [
            'name' => v::stringType()->length(1, 255),
            'position' => v::optional(v::stringType()->length(1, 255)),
            'twitter' => v::optional(v::stringType()->length(1, 255)),
            'link' => v::optional(v::stringType()->length(1, 255)->url())
        ];

        $validation = $this->validator->validate(Flight::request()->data, $validationArray);

        if ($validation->failed()) {
            Flash::message('danger', '<strong>Error!</strong>, compruebe los errores en el formulario.');
            Flash::data(Flight::request()->data);

            if ($id) {
                Flight::redirect('/author/edit/'.$id);
            } else {
                Flight::redirect('/author/create');
            }
        }

        // Validated Rules
        $name = filter_var(trim(Flight::request()->data['name']), FILTER_SANITIZE_STRING);
        $position = filter_var(trim(Flight::request()->data['position']), FILTER_SANITIZE_STRING);
        $twitter = filter_var(trim(Flight::request()->data['twitter']), FILTER_SANITIZE_STRING);
        $link = filter_var(trim(Flight::request()->data['link']), FILTER_SANITIZE_URL);

        if (!empty(Flight::request()->files['image']['size'])) {
            try {
                $imageName = $this->image->upload('image');
            } catch (\Exception $e) {
                Flash::message('danger', '<strong>Error!</strong>, compruebe los errores en el formulario.');
                $_SESSION['validationErrors']['image'] = $e->getMessage();
            }
        }

        /* Guarda en la tabla normal */
        if ($id) {
            $save = ORM::for_table('author')->find_one($id);
        } else {
            $save = ORM::for_table('author')->create();
            $save->slug = $this->slugify->slugify($name);
        }

        $save->name = $name;
        $save->position = $position;
        $save->twitter = $twitter;
        $save->link = $link;
        if (isset($imageName) && $imageName) {
            $save->image = $imageName;
        }

        $save->save();

        Flight::redirect('/author/edit/'.$save->id());
    }
}
