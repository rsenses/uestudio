<?php

namespace Expomark\Models;

class Json
{
    public function getAll($scan)
    {
        $files = new Files();
        $experts = [];
        foreach ($files->getDir($scan) as $file) {
            $experts[] = json_decode($file, true);
        }

        return $experts;
    }

    public function getOne($scan)
    {
        $file = new Files();

        return json_decode($file->getFile($scan), true);
    }
}
