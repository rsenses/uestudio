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

class Image
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
        $webName = filter_var(Flight::request()->data['webname'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

        $folder = $GLOBALS['config']['uploads_dir'].'images/';

        $storage = new FileSystem($folder.$webName.'/');

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
            $imageName = $file->getNameWithExtension();

            if (isset($GLOBALS['config']['images'][$webName])) {
                foreach ($GLOBALS['config']['images'][$webName] as $key => $size) {
                    $resizable = $this->imagine->open($folder.$webName.'/'.$imageName);

                    $imageSize  = $resizable->getSize();

                    $resizable->resize($imageSize->widen($size))
                        ->save($folder.$webName.'/'.$key.'_'.$imageName);
                }
            }

            return $imageName;
        } catch (\Exception $e) {
            if ($file->getErrors()) {
                throw new Exception($file->getErrors()[0]);
            } else {
                throw new Exception($e->getMessage());
            }

        }
    }
}
