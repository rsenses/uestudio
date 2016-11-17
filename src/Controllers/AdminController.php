<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use JasonGrimes\Paginator;
use Flight;

class AdminController
{
    public function __construct()
    {
        Flight::db();
        Flight::eloquent();
        if (!Sentry::check()) {
            Flight::redirect('/users/login/'.base64_encode(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING)));
        }
    }

    // CONTENIDO ********************************************************
    public function videosAction($page = null)
    {
        // Datos necesarios para el paginador
        $page = $page ?: 1;
        $itemsPerPage = 20;
        $urlPattern = '/admin/(:num)';

        $content = ORM::for_table('videos')
            ->select('videos.id')
            ->select('videos.title')
            ->select('videos.date')
            ->select('videos.section')
            ->select('videos.active')
            ->select('videos.important')
            ->select_expr('GROUP_CONCAT(DISTINCT `tags`.`tag`)', 'tags')
            ->select_expr('GROUP_CONCAT(DISTINCT `sectionTags`.`tag`)', 'sections')
            ->left_outer_join('tagLinks', array('tagLinks.content_id', '=', 'videos.id'))
            ->left_outer_join('tags', array('tags.id', '=', 'tagLinks.tag_id'))
            ->join('section', array('section.content_id', '=', 'videos.id'))
            ->join('tags', array('sectionTags.id', '=', 'section.tag_id'), 'sectionTags')
            ->group_by('videos.id')
            ->order_by_desc('videos.id')
            ->limit($itemsPerPage)
            ->offset(($page - 1) * $itemsPerPage)
            ->find_many();

        $totalItems = ORM::for_table('videos')
            ->count();

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'videos.phtml',
            array(
                'section' => 'videos',
                'paginator' => new Paginator($totalItems, $itemsPerPage, $page, $urlPattern),
                'content' => $content,
            )
        );
    }
}
