<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Cocur\Slugify\Slugify;
use JasonGrimes\Paginator;
use Kunststube\CSRFP\SignatureGenerator;
use Joelvardy\Flash;
use Flight;

class UserController
{
    private $slugify;
    private $signer;

    public function __construct()
    {
        Flight::db();
        Flight::eloquent();
        $this->slugify = new Slugify();
        $this->signer = new SignatureGenerator($GLOBALS['config']['info']['secret_word']);
    }

    public function indexAction($page = null)
    {
        if (!Sentry::check()) {
            Flight::redirect('/users/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }

        // Datos necesarios para el paginador
        $page = $page ?: 1;
        $itemsPerPage = 20;
        $urlPattern = '/users/(:num)';

        //realizamos la consulta de todos los items
        $content = ORM::for_table('users')
            ->select('id')
            ->select('email')
            ->select('first_name')
            ->select('last_name')
            ->order_by_desc('id')
            ->limit($itemsPerPage)
            ->offset(($page - 1) * $itemsPerPage)
            ->find_many();

        $totalItems = ORM::for_table('users')
            ->count();

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'users.phtml',
            array(
                'section' => 'users',
                'paginator' => new Paginator($totalItems, $itemsPerPage, $page, $urlPattern),
                'content' => $content,
            )
        );
    }

    public function editAction($id = null, $content = null, $errors = null)
    {
        if (!Sentry::check()) {
            Flight::redirect('/users/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }

        if ($id) {
            $content = ORM::for_table('users')
                ->find_one($id)
                ->as_array();
        }

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'editusers.phtml',
            array(
                'section' => 'users',
                'errors' => $errors,
                'content' => $content,
            )
        );
    }

    public function deleteAction($id)
    {
        if (!Sentry::check()) {
            Flight::redirect('/users/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }

        // Find the user using the user id
        $user = Sentry::findUserById($id);

        // Delete the user
        $user->delete();

        Flight::redirect('/users/');
    }

    public function searchAction()
    {
        $searchTerm = Flight::request()->query['term'];

        if (empty($searchTerm)) {
            Flight::notFound();
            die;
        }

        $content = ORM::for_table('users')
            ->distinct()->select('id')
            ->select('email')
            ->select('first_name')
            ->select('last_name')
            ->where_any_is([
                ['email' => '%'.$searchTerm.'%'],
                ['first_name' => '%'.$searchTerm.'%'],
                ['last_name' => '%'.$searchTerm.'%'],
            ], ['email' => 'LIKE', 'first_name' => 'LIKE', 'last_name' => 'LIKE'])
            ->group_by('id')
            ->order_by_desc('id')
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

    public function loginPageAction($url, $email = null)
    {
        echo Flight::view()->render(
            'login.phtml',
            array(
                'url' => $url,
                'token' => $this->signer->getSignature(),
                'email' => $email,
            )
        );
    }

    public function loginAction($url)
    {
        if (isset(Flight::request()->data['Submit']) && empty(Flight::request()->data['name'])) {
            if ($this->signer->validateSignature(Flight::request()->data['_token'])) {
                $email = empty(Flight::request()->data['email']) ? null : (Flight::request()->data['email'] === 'Email') ? null : filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = empty(Flight::request()->data['password']) ? null : filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

                try {
                    // Login credentials
                    $credentials = array(
                        'email' => $email,
                        'password' => $password,
                    );

                    // Authenticate the user
                    $user = Sentry::authenticate($credentials, true);

                    if ($url) {
                        $url = base64_decode($url);
                        Flight::redirect($url);
                    } else {
                        Flight::redirect();
                    }
                } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
                    Flash::message('danger', '<strong>Error</strong>, Login field is required.');
                } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    Flash::message('danger', '<strong>Error</strong>, User not found.');
                } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                    Flash::message('danger', '<strong>Error</strong>, User not activated.');
                }
                // Following is only needed if throttle is enabled
                catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                    Flash::message('danger', '<strong>Error</strong>, User is suspended.');
                } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
                    Flash::message('danger', '<strong>Error</strong>, User is banned.');
                }
                $this->loginPageAction($url, $email);
            }
        }
    }

    public function timeoutAction($email, $url)
    {
        $inactiveTime = $GLOBALS['config']['security']['cookie_minutes'] > 1 ? $GLOBALS['config']['security']['cookie_minutes'].' minutos' : $GLOBALS['config']['security']['cookie_minutes'].'minuto';

        Flash::message('danger', 'Ha sido desconectado por permanecer mas de '.$inactiveTime.' inactivo. Disculpe las molestias.');

        //devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'login.phtml',
            array(
                'url' => $url,
                'email' => base64_decode($email),
            )
        );
    }

    public function logoutAction()
    {
        Sentry::logout();
        Flight::redirect('/');
    }

    public function saveAction($id)
    {
        if (!Sentry::check()) {
            Flight::redirect('/users/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }

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
