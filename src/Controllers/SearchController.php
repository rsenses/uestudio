<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Flight;

class SearchController
{
    public function __construct()
    {
        Flight::db();
        Flight::eloquent();

        if (!Sentry::check()) {
            Flight::redirect('/users/login/' . base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }
    }

    // BUSCAR ********************************************************
    public function videosAction()
    {
        $searchTerm = Flight::request()->query['term'];
        if (!$searchTerm) {
            Flight::redirect(filter_var(Flight::request()->referrer, FILTER_SANITIZE_URL));
        }

        $content = ORM::for_table('videos')
            ->distinct()->select('videos.id')
            ->select('videos.title')
            ->select('videos.active')
            ->select('videos.date')
            ->select('videos.section')
            ->select_expr('GROUP_CONCAT(`tags`.`tag`)', 'tags')
            ->select('sectionTags.tag', 'sections')
            ->left_outer_join('tagLinks', ['tagLinks.content_id', '=', 'videos.id'])
            ->left_outer_join('tags', ['tags.id', '=', 'tagLinks.tag_id'])
            ->left_outer_join('section', ['section.content_id', '=', 'videos.id'])
            ->left_outer_join('tags', ['sectionTags.id', '=', 'section.tag_id'], 'sectionTags')
            ->where_any_is([
                ['videos.title' => '%' . $searchTerm . '%'],
                ['sectionTags.tag' => '%' . $searchTerm . '%'],
            ], ['videos.title' => 'LIKE', 'sectionTags.tag' => 'LIKE'])
            ->group_by('videos.id')
            ->order_by_desc('videos.id')
            ->find_many();

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'videos.phtml',
            [
                'section' => 'videos',
                'searchTerm' => $searchTerm,
                'paginator' => null,
                'content' => $content,
            ]
        );
    }
}
