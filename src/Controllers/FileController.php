<?php

namespace Expomark\Controllers;

use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Expomark\Upload\Image;
use Flight;

class FileController
{
    public function __construct()
    {
        Flight::db();
        Flight::eloquent();

        if (!Sentry::check()) {
            Flight::redirect('/users/login/' . base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
            die;
        }

        $this->image = new Image();
    }

    public function uploadAction()
    {
        $response['status'] = 'error';

        if (!empty(Flight::request()->files['inline_upload_file']['size'])) {
            try {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, Flight::request()->files['inline_upload_file']['tmp_name']);

                $webName = filter_var(Flight::request()->data['webname'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $imageName = $this->image->upload('inline_upload_file');

                if (in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'])) {
                    $mimeType = 'images';
                } else {
                    $mimeType = 'files';
                }

                $response['status'] = 'success';
                $response['src'] = $GLOBALS['config']['cdn_url'] . '/' . $mimeType . '/' . $webName . '/' . $imageName;
            } catch (\Exception $e) {
                $response['msg'] = $e->getMessage();
            }
        }

        Flight::json($response);
    }
}
