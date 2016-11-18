<?php

namespace Expomark\Upload;

use Exception;
use Flight;
use Upload\Storage\FileSystem;
use Upload\File;
use Upload\Validation\Mimetype;
use Upload\Validation\Size;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Cocur\Slugify\Slugify;

class AuthorImage
{
    private $imagine;
    private $slugify;

    public function __construct()
    {
        $this->imagine = new Imagine();
        $this->slugify = new Slugify();
    }

    public function upload($input)
    {
        $storage = new FileSystem($GLOBALS['config']['uploads_dir'].'images/author');

        $file = new File($input, $storage);

        $image = time().'_'.$this->slugify->slugify($file->getName());

        $file->setName($image);
        $file->addValidations(array(
            new Mimetype(array('image/jpeg', 'image/png', 'image/gif')),
            new Size('500K'),
        ));

        try {
            // Success!
            $file->upload();
            return $file->getNameWithExtension();
        } catch (\Exception $e) {
            if ($file->getErrors()) {
                throw new Exception($file->getErrors()[0]);
            } else {
                throw new Exception($e->getMessage());
            }

        }
    }
}
