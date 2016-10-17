<?php

namespace Expomark\Models;

use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent
{
    public function __construct($dbDriver, $dbHost, $dbName, $dbUser, $dbPass)
    {
        // Create a new Database connection
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => $dbDriver,
            'host' => $dbHost,
            'database' => $dbName,
            'username' => $dbUser,
            'password' => $dbPass,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        $capsule->bootEloquent();
    }
}
