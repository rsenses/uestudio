<?php

namespace Expomark\Models;

use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent
{
    public function __construct($drive, $host, $database, $user, $pass)
    {
        // Create a new Database connection
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => $drive,
            'host' => $host,
            'database' => $database,
            'username' => $user,
            'password' => $pass,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        $capsule->bootEloquent();
    }
}
