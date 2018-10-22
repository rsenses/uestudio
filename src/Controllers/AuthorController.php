<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Cocur\Slugify\Slugify;
use JasonGrimes\Paginator;
use Joelvardy\Flash;
use Flight;
use Respect\Validation\Validator as v;
use Expomark\Validation\Validator;
use Expomark\Upload\AuthorImage;

class AuthorController
{
    private $image;
    private $slugify;
    private $validator;

    public function __construct()
    {
        Flight::db();
        Flight::eloquent();

        if (!Sentry::check()) {
            Flight::redirect('/author/login/' . base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
            die;
        }

        $this->image = new AuthorImage();
        $this->validator = new Validator();
        $this->slugify = new Slugify();
    }

    public function indexAction($page = null)
    {
        // Datos necesarios para el paginador
        $page = $page ?: 1;
        $itemsPerPage = 20;
        $urlPattern = '/author/(:num)';

        //realizamos la consulta de todos los items
        $authors = ORM::for_table('author')
            ->order_by_asc('name')
            ->limit($itemsPerPage)
            ->offset(($page - 1) * $itemsPerPage)
            ->find_many();

        $totalItems = ORM::for_table('author')
            ->count();

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'authors.phtml',
            [
                'section' => 'author',
                'paginator' => new Paginator($totalItems, $itemsPerPage, $page, $urlPattern),
                'authors' => $authors,
            ]
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
            [
                'section' => 'author',
                'author' => $author,
                'id' => $id,
            ]
        );
    }

    public function searchAction()
    {
        $searchTerm = Flight::request()->query['term'];
        if (empty($searchTerm)) {
            Flight::notFound();
            die;
        }

        $authors = ORM::for_table('author')
            ->where_like('name', "%$searchTerm%")
            ->order_by_asc('name')
            ->find_many();

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'authors.phtml',
            [
                'section' => 'author',
                'searchTerm' => $searchTerm,
                'paginator' => null,
                'authors' => $authors,
            ]
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
                Flight::redirect('/author/edit/' . $id);
            } else {
                Flight::redirect('/author/create');
            }
            die;
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

        // Guarda en la tabla normal
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

        Flight::redirect('/author/edit/' . $save->id());
        die;
    }
}
