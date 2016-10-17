<?php

namespace Expomark\Models;

class Author
{
    private $author;

    public function __construct($options = null)
    {
        $options = json_decode($options);
        $this->author = $options->author;
    }

    public function getAuthor()
    {
        $json = new Json();
        $expert = $json->getOne(__DIR__.'/Author/'.$this->author.'.json');
        if ($expert) {
            return $expert;
        } else {
            return null;
        }
    }
}
