<?php

namespace Expomark\Controllers;

use Cocur\Slugify\Slugify;
use Upload\Storage\FileSystem;
use Upload\File;
use Upload\Validation\Mimetype;
use Upload\Validation\Size;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Flight;

class FileController
{
    private $slugify;

    public function __construct()
    {
        Flight::db();
        Flight::eloquent();
        if (!Sentry::check()) {
            Flight::redirect('/users/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }
        $this->slugify = new Slugify();
    }

    public function uploadAction()
    {
        if ($_FILES['inline_upload_file']['type'] == 'image/jpeg' || $_FILES['inline_upload_file']['type'] == 'image/gif' || $_FILES['inline_upload_file']['type'] == 'image/png') {
            $folder = $GLOBALS['config']['uploads_dir'].'images/';
            $src = '/uploads/images/';
            $response['type'] = 'image';
        } else {
            $folder = $GLOBALS['config']['uploads_dir'].'files/';
            $src = '/uploads/files/';
            $response['type'] = 'file';
        }

        $storage = new FileSystem($folder);
        $file = new File('inline_upload_file', $storage);
        $upload = time().'_'.$this->slugify->slugify($_FILES['inline_upload_file']['name']);
        $file->setName($upload);
        $file->addValidations(array(
            new Mimetype(
                array('image/png', 'image/gif', 'image/jpeg', 'image/svg+xml', 'application/pdf', 'application/x-pdf')
            ),
            new Size('600K'),
        ));

        try {
            // Success!
            $file->upload();
            $upload = $file->getNameWithExtension();
            $info = getImageSize($folder.$upload);
            $response['status'] = 'success';
            $response['width'] = $info[0];
            $response['height'] = $info[1];
            $response['src'] = $src.$upload;
        } catch (\Exception $e) {
            // Fail!
            $response['status'] = 'error';
            if (isset($file->getErrors()[0])) {
                $response['msg'] = $file->getErrors()[0];
            }
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }
}
