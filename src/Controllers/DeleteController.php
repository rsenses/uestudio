<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Flight;

class DeleteController
{
    public function __construct()
    {
        Flight::db();
        Flight::eloquent();
        if (!Sentry::check()) {
            Flight::redirect('/users/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }
    }

    // VIDEOS **********************************************************************************************************
    public function videosAction($id)
    {
        // Borramos la entrada de la BD
        $delete = ORM::for_table('videos')->find_one($id);
        $delete->delete();

        Flight::redirect('/');
    }
}
