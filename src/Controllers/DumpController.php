<?php

namespace Expomark\Controllers;

use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Flight;

class DumpController
{
    public function __construct()
    {
        Flight::db();
        Flight::eloquent();

        if (!Sentry::check()) {
            Flight::redirect('/users/login/' . base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
            die;
        }
    }

    // BUSCAR ********************************************************
    public function indexAction()
    {
        $database = $GLOBALS['env']['db']['database'];
        $user = $GLOBALS['env']['db']['user'];
        $pass = $GLOBALS['env']['db']['pass'];
        $host = $GLOBALS['env']['db']['host'];
        $filename = 'backup-' . date('d-m-Y') . '.sql.gz';
        $dir = __DIR__ . '/../../public/uploads/files/' . $filename;

        // echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";

        // exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1", $output);

        // var_dump($output);
        // die;

        $mime = 'application/x-gzip';

        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $cmd = "mysqldump -u $user --password=$pass $database | gzip --best";

        passthru($cmd);

        exit(0);
    }
}
