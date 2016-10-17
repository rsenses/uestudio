<?php

namespace Expomark\Models;

use SplFileObject;

class Csv
{
    public function saveFile($file, $data)
    {
        if (is_file($file)) {
            $file = new SplFileObject($file, 'a');
            $file->fputcsv($data);
        } else {
            throw new \Exception('The provided Path is not a valid File.');
        }
    }
}
