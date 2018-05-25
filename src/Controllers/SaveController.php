<?php

namespace Expomark\Controllers;

use ORM;
use DateTime;
use Cocur\Slugify\Slugify;
use Joelvardy\Flash;
use Cartalyst\Sentry\Facades\Native\Sentry as Sentry;
use Flight;
use Respect\Validation\Validator as v;
use Expomark\Validation\Validator;
use Expomark\Upload\Image;

class SaveController
{
    private $image;
    private $slugify;
    private $validator;

    public function __construct()
    {
        Flight::db()->memcached();
        Flight::eloquent();
        if (!Sentry::check()) {
            Flight::redirect('/users/login/' . base64_encode(urlencode(Flight::request()->url)));
        }

        $this->image = new Image();
        $this->validator = new Validator();
        $this->slugify = new Slugify();
    }

    // VIDEOS  ****************************************************************
    public function videosAction($id = null)
    {
        $validationArray = [
            'webname' => v::stringType()->noWhitespace()->notEmpty()->length(1, 255)->in(array_keys($GLOBALS['config']['enum']['webs_name'])),
            'title' => v::stringType()->notEmpty()->length(1, 255)->unique('videos', 'url', $id),
            'subtitle' => v::stringType(),
            'section' => v::stringType(),
            'tags' => v::stringType(),
            'content' => v::stringType()->notEmpty(),
            'author' => v::intVal()->notEmpty(),
            'facebook' => v::stringType()->notEmpty()->length(1, 300),
            'description' => v::stringType()->notEmpty()->length(1, 160),
            'twitter' => v::stringType()->notEmpty()->length(1, 140),
        ];

        if (Flight::request()->data['date']) {
            $validationArray['date'] = v::date();
        }

        $validation = $this->validator->validate(Flight::request()->data, $validationArray);

        if ($validation->failed()) {
            Flash::message('danger', '<strong>Error!</strong>, compruebe los errores en el formulario.');
            Flash::data(Flight::request()->data);
            if ($id) {
                Flight::redirect('/edit/' . $id);
            } else {
                Flight::redirect('/edit');
            }
        }

        // Validated Rules
        $webName = filter_var(Flight::request()->data['webname'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $title = trim(Flight::request()->data['title']);
        $slug = $this->slugify->slugify(
            strip_tags(
                preg_replace("/<br\s?\/?>/", ' ', trim(Flight::request()->data['title']))
            )
        );
        $subtitle = trim(Flight::request()->data['subtitle']);
        $content = Flight::request()->data['content'];
        $facebook = filter_var(trim(Flight::request()->data['facebook']), FILTER_SANITIZE_STRING);
        $description = filter_var(trim(Flight::request()->data['description']), FILTER_SANITIZE_STRING);
        $twitter = filter_var(trim(Flight::request()->data['twitter']), FILTER_SANITIZE_STRING);
        $vimeo = filter_var(trim(Flight::request()->data['vimeo']), FILTER_SANITIZE_STRING);
        $author = Flight::request()->data['author'] > 0 ? filter_var(trim(Flight::request()->data['author']), FILTER_SANITIZE_NUMBER_INT) : null;

        if (Flight::request()->data['date']) {
            $dateTime = Flight::request()->data['date'];
        } else {
            $dt = new DateTime();
            $dateTime = $dt->format('Y-m-d H:i:s');
        }

        $optionNames = Flight::request()->data['option_name'];
        $optionValues = Flight::request()->data['option'];

        $options = [];
        foreach ($optionNames as $key => $name) {
            $name = filter_var($optionNames[$key], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            if ($optionValues[$key]) {
                $options[$name] = $optionValues[$key];
            }
        }

        if (!empty(Flight::request()->files['image']['size'])) {
            try {
                $imageName = $this->image->upload('image');
            } catch (\Exception $e) {
                Flash::message('danger', '<strong>Error!</strong>, compruebe los errores en el formulario.');
                $_SESSION['validationErrors']['image'] = $e->getMessage();
            }
        }

        if (!empty(Flight::request()->files['vertical']['size'])) {
            try {
                $verticalName = $this->image->upload('vertical');
            } catch (\Exception $e) {
                Flash::message('danger', '<strong>Error!</strong>, compruebe los errores en el formulario.');
                $_SESSION['validationErrors']['vertical'] = $e->getMessage();
            }
        }

        if (!empty(Flight::request()->files['slider']['size'])) {
            try {
                $sliderName = $this->image->upload('slider');
            } catch (\Exception $e) {
                Flash::message('danger', '<strong>Error!</strong>, compruebe los errores en el formulario.');
                $_SESSION['validationErrors']['slider'] = $e->getMessage();
            }
        }

        // Guarda en la tabla normal
        if ($id) {
            $save = ORM::for_table('videos')->find_one($id);
        } else {
            $save = ORM::for_table('videos')->create();
            $save->active = 0;
        }
        $save->title = $title;
        $save->url = $slug;
        $save->subtitle = $subtitle;
        $save->content = $content;
        $save->description = $description;
        if (isset($imageName) && $imageName) {
            $save->image = $webName . '/' . $imageName;
        }
        if (isset($verticalName) && $verticalName) {
            $save->vertical = $webName . '/' . $verticalName;
        }
        if (isset($sliderName) && $sliderName) {
            $save->slider = $webName . '/' . $sliderName;
        }
        $save->vimeo = $vimeo;
        $save->twitter = $twitter;
        $save->facebook = $facebook;
        $save->author_id = $author;
        $save->date = $dateTime;
        $save->section = $webName;
        $save->options = json_encode($options);

        $save->save();

        $id = $save->id;

        // Section Tags
        $section = array_map('trim', array_filter(explode(',', Flight::request()->data['section'])));

        $deleteTags = ORM::for_table('section')
            ->where_equal('content_id', $id)
            ->delete_many();

        foreach ($section as $key => $sect) {
            $sectionExist = ORM::for_table('tags')
                ->select('id')
                ->where('tag', $sect)
                ->find_one();

            if (!$sectionExist) {
                $save = ORM::for_table('tags')->create();
                $save->tag = $sect;
                $save->url = $this->slugify->slugify($sect);
                $save->save();
                $section_id = $save->id;
            } else {
                $section_id = $sectionExist['id'];
            }

            $save = ORM::for_table('section')->create();
            $save->tag_id = $section_id;
            $save->content_id = $id;
            $save->table = $webName;
            $save->created_at = date('Y-m-d H:i:s');
            $save->save();
        }

        // Tags
        $deleteTags = ORM::for_table('tagLinks')
            ->where_equal('content_id', $id)
            ->delete_many();

        if (Flight::request()->data['tags']) {
            $tags = array_map('trim', array_filter(explode(',', Flight::request()->data['tags'])));

            foreach ($tags as $key => $tag) {
                $tagExist = ORM::for_table('tags')
                    ->select('id')
                    ->where('tag', $tag)
                    ->find_one();

                if (!$tagExist) {
                    $save = ORM::for_table('tags')->create();
                    $save->tag = $tag;
                    $save->url = $this->slugify->slugify($tag);
                    $save->save();
                    $tag_id = $save->id;
                } else {
                    $tag_id = $tagExist['id'];
                }

                $save = ORM::for_table('tagLinks')->create();
                $save->tag_id = $tag_id;
                $save->content_id = $id;
                $save->table = $webName;
                $save->created_at = date('Y-m-d H:i:s');
                $save->save();
            }
        }

        Flight::redirect('/edit/' . $id);
    }
}
