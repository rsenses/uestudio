<?php

namespace Expomark\Models;

use DirectoryIterator;

class Files
{
    public function getDir($scan)
    {
        $dir = new DirectoryIterator($scan);
        $stringArray = [];
        foreach ($dir as $fileInfo) {
            if (
                !$fileInfo->isDot()
                && $fileInfo->isFile()
                && strpos($fileInfo->getFilename(), '.json') !== false
                && $fileInfo->getFilename()[0] !== '.'
            ) {
                $stringArray[] = file_get_contents($fileInfo->getPathname());
            }
        }

        return $stringArray;
    }

    public function getFile($file)
    {
        if (is_file($file)) {
            return file_get_contents($file);
        } else {
            return false;
        }
    }
}
