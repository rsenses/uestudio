<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use JasonGrimes\Paginator;
use Flight;

class SearchController
{
    public function __construct()
    {
        Flight::db();
        Flight::eloquent();
        if (!Sentry::check()) {
            Flight::redirect('/users/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
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
            ->select_expr('GROUP_CONCAT(`sectionTags`.`tag`)', 'sections')
            ->left_outer_join('tagLinks', array('tagLinks.content_id', '=', 'videos.id'))
            ->left_outer_join('tags', array('tags.id', '=', 'tagLinks.tag_id'))
            ->join('section', array('section.content_id', '=', 'videos.id'))
            ->join('tags', array('sectionTags.id', '=', 'section.tag_id'), 'sectionTags')
            ->where_raw('MATCH(title, subtitle) AGAINST (?)', array($searchTerm))
            // ->where_raw('MATCH(title, subtitle, content) AGAINST (?)', array($searchTerm))
            ->group_by('videos.id')
            ->order_by_desc('videos.id')
            ->find_many();

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'videos.phtml',
            array(
                'section' => 'videos',
                'searchTerm' => $searchTerm,
                'paginator' => null,
                'content' => $content,
            )
        );
    }
}
