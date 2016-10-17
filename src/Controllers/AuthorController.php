<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Cocur\Slugify\Slugify;
use JasonGrimes\Paginator;
use Kunststube\CSRFP\SignatureGenerator;
use Joelvardy\Flash;
use Flight;

class AuthorController
{
    private $slugify;
    private $signer;

    public function __construct()
    {
        Flight::db();
        Flight::eloquent();
        if (!Sentry::check()) {
            Flight::redirect('/author/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }
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

    public function editAction($id = null, $content = null, $errors = null)
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
                'errors' => $errors,
                'author' => $author,
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
        if (isset(Flight::request()->data['Submit'])) {
            $error = false;
            if (Flight::request()->data['email']) {
                if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                    Flash::message('danger', '<strong>Error</strong>, el email introducido no es válido.');
                    $error = true;
                } else {
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                }
            } else {
                Flash::message('danger', '<strong>Error</strong>, debes introducir el <strong>Email</strong>.');
                $error = true;
            }
            if (!Flight::request()->data['first_name']) {
                Flash::message('danger', '<strong>Error</strong>, debes introducir el <strong>nombre</strong>.');
                $error = true;
            }
            if (!Flight::request()->data['last_name']) {
                Flash::message('danger', '<strong>Error</strong>, debes introducir los <strong>apellidos</strong>.');
                $error = true;
            }
            if (!$id) {
                if (!Flight::request()->data['password']) {
                    Flash::message('danger', '<strong>Error</strong>, debes introducir la <strong>contraseña</strong>.');
                    $error = true;
                }
                if (!Flight::request()->data['confirmPassword']) {
                    Flash::message('danger', '<strong>Error</strong>, debes introducir la <strong>confirmación</strong> de la contraseña.');
                    $error = true;
                }
                if (Flight::request()->data['confirmPassword'] !== Flight::request()->data['password']) {
                    Flash::message('danger', '<strong>Error</strong>, las <strong>contraseñas no coinciden</strong>.');
                    $error = true;
                }
            }

            if (!$id) {
                $emailCount = ORM::for_table('users')
                    ->where('email', Flight::request()->data['email'])
                    ->count();
                if ($emailCount) {
                    Flash::message('danger', '<strong>Error</strong>, email <strong>duplicado</strong>.');
                    $error = true;
                }
            }

            if (!$error) {
                if ($id) {
                    try {
                        // Find the user using the user id
                        $user = Sentry::findUserById($id);

                        // Update the user details
                        $user->email = $email;
                        $user->first_name = Flight::request()->data['first_name'];
                        $user->last_name = Flight::request()->data['last_name'];
                        if (isset(Flight::request()->data['password']) && isset(Flight::request()->data['confirmPassword']) && Flight::request()->data['confirmPassword'] === Flight::request()->data['password']) {
                            $user->password = Flight::request()->data['password'];
                        }

                        // Update the user
                        if ($user->save()) {
                            $this->editAction($id);
                        }
                    } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
                        Flash::message('danger', '<strong>Error</strong>, usuario duplicado.');
                        $error = true;
                    } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                        Flash::message('danger', '<strong>Error</strong>, usuario no encontrado.');
                        $error = true;
                    }
                } else {
                    try {
                        // Create the user
                        $user = Sentry::createUser(array(
                            'email' => $email,
                            'first_name' => Flight::request()->data['first_name'],
                            'last_name' => Flight::request()->data['last_name'],
                            'password' => Flight::request()->data['password'],
                            'permissions' => array(
                                'admin.view' => 1,
                                'admin.add' => 1,
                                'admin.edit' => 1,
                                'admin.delete' => 1,
                            ),
                            'activated' => true,
                            'activated_at' => date('Y-m-d H:i:s'),
                            'created_at' => date('Y-m-d H:i:s'),
                        ));
                        $this->editAction($user['attributes']['id']);
                    } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
                        Flash::message('danger', '<strong>Error</strong>, email requerido.');
                        $error = true;
                    } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
                        Flash::message('danger', '<strong>Error</strong>, password requerido.');
                        $error = true;
                    } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
                        Flash::message('danger', '<strong>Error</strong>, usuario duplicado.');
                        $error = true;
                    } catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
                        Flash::message('danger', '<strong>Error</strong>, grupo no encontrado.');
                        $error = true;
                    }
                }
            } else {
                if ($id) {
                    $this->editAction($id);
                } else {
                    $user = array(
                        'id' => null,
                        'email' => Flight::request()->data['email'],
                        'password' => Flight::request()->data['password'],
                        'confirmPassword' => Flight::request()->data['confirmPassword'],
                        'first_name' => Flight::request()->data['first_name'],
                        'last_name' => Flight::request()->data['last_name'],
                    );
                    $this->editAction(0, $user);
                }
            }
        } else {
            $this->editAction();
        }
    }
}
