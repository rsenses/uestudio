<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Flight;

class ExportController
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

    public static function indexAction($id)
    {
        $video = ORM::for_table('videos')->find_one($id);

        $answers = ORM::for_table('poll')
            ->where('poll', $video->url)
            ->find_many();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sample.csv"');

        $fp = fopen('php://output', 'wb');
        $headers = json_decode($answers[0]->json, true);
        unset($headers['legal'], $headers['privacy'], $headers['product_id']);
        $headers = array_keys($headers);
        fputcsv($fp, $headers);
        foreach ($answers as $line) {
            $val = json_decode($line->json, true);
            unset($val['legal'], $val['privacy'], $val['product_id']);
            fputcsv($fp, $val);
        }
        fclose($fp);
        die;
    }
}
