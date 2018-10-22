<?php

namespace Expomark\Controllers;

use ORM;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Flight;

class EditController
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

    // VIDEOS  **********************************************************************************************************
    public function videosAction($id, $content = null)
    {
        if ($id) {
            $content = ORM::for_table('videos')
                ->select('videos.id')
                ->select('videos.title')
                ->select('videos.url')
                ->select('videos.subtitle')
                ->select('videos.content')
                ->select('videos.description')
                ->select('videos.image')
                ->select('videos.slider')
                ->select('videos.vertical')
                ->select('videos.youtube')
                ->select('videos.vimeo')
                ->select('videos.external_url')
                ->select('videos.twitter')
                ->select('videos.facebook')
                ->select('videos.styles')
                ->select('videos.date')
                ->select('videos.active')
                ->select('videos.author_id')
                ->select('videos.section', 'webname')
                ->select('videos.author_id')
                ->select('videos.options')
                ->select('sectionTags.tag', 'section')
                ->select('sectionTags.url', 'section_url')
                ->select_expr('GROUP_CONCAT(DISTINCT `tags`.`tag`)', 'tags')
                ->left_outer_join('tagLinks', ['tagLinks.content_id', '=', 'videos.id'])
                ->left_outer_join('tags', ['tags.id', '=', 'tagLinks.tag_id'])
                ->left_outer_join('section', ['section.content_id', '=', 'videos.id'])
                ->left_outer_join('tags', ['sectionTags.id', '=', 'section.tag_id'], 'sectionTags')
                ->group_by('videos.id')
                ->order_by_desc('videos.id')
                ->limit(1)
                ->find_one($id);

            if ($content->webname === 'potenciatupyme') {
                $content->link = $GLOBALS['config']['enum']['webs_url'][$content->webname] . 'video/' . $content->url;
            } else {
                $content->link = $GLOBALS['config']['enum']['webs_url'][$content->webname] . $content->section_url . '/' . $content->url;
            }

            $rating = ORM::for_table('ratings')
                ->where('video_id', $content->id)
                ->find_many();

            if ($rating) {
                $ratingSum = array_reduce($rating, function ($carry, $item) {
                    $carry += $item->rating;
                    return $carry;
                });

                $ratingCount = count($rating);
            }
        }

        $autocomplete = ORM::for_table('tags')
            ->select('tag')
            ->find_many();
        $tags = implode(', ', array_map(function ($entry) {
            return $entry['tag'];
        }, $autocomplete));
        $tags = explode(', ', $tags);

        $authors = ORM::for_table('author')
            ->select('author_id')
            ->select('name')
            ->order_by_asc('name')
            ->find_many();

        // devolvemos la coleccion para que la vista la presente.
        echo Flight::view()->render(
            'editvideos.phtml',
            [
                'section' => 'videos',
                'autocomplete' => isset($tags) ? json_encode($tags) : null,
                'authors' => $authors,
                'content' => $content,
                'id' => $id,
                'ratingSum' => $ratingSum ?? null,
                'ratingCount' => $ratingCount ?? null,
            ]
        );
    }

    public static function importantAction($id)
    {
        $video = ORM::for_table('videos')
            ->find_one($id);

        if ($video->section !== 'loquehayquever' && $video->section !== 'laprevia' && $video->section !== 'yodonabeautybrandsplace' && $video->section !== 'unpaseoporelprado') {
            $old = ORM::for_table('videos')
                ->where('section', $video->section)
                ->where('important', 1)
                ->find_one();

            if ($old->id) {
                $old->important = 0;
                $old->save();
            }
        }

        $video->important = !$video->important;

        $video->save();

        Flight::redirect(filter_var(Flight::request()->referrer, FILTER_SANITIZE_URL));
        die;
    }

    public static function activeAction($id)
    {
        $video = ORM::for_table('videos')->find_one($id);
        $video->active = 1;
        $video->save();

        Flight::redirect(filter_var(Flight::request()->referrer, FILTER_SANITIZE_URL));
        die;
    }

    public static function deactiveAction($id)
    {
        $video = ORM::for_table('videos')->find_one($id);
        $video->active = 0;
        $video->save();

        Flight::redirect(filter_var(Flight::request()->referrer, FILTER_SANITIZE_URL));
        die;
    }
}
