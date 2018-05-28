<?php

namespace Expomark\Models;

use ORM;
use Illuminate\Database\Capsule\Manager as Capsule;

class Db
{
    public function __construct($driver, $host, $port, $database, $user, $pass, $set = true)
    {
        // IdiORM Configuration
        if ($driver === 'sqlite') {
            ORM::configure('connection_string', $driver.':'.$GLOBALS['env']['paths']['sqlite'].$database.'.sqlite');
        } else {
            ORM::configure('connection_string', $driver.':host='.$host.';dbname='.$database.';port='.$port);
            ORM::configure('username', $user);
            ORM::configure('password', $pass);
            if ($driver === 'mysql') {
                ORM::configure('driver_options', [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
            }
        }

        ORM::configure('id_column_overrides', [
            'author' => 'author_id'
        ]);

        if ($set) {
            ORM::configure('return_result_sets', false);
        }

        if ($GLOBALS['env']['debug']) {
            ORM::configure('error_mode', \PDO::ERRMODE_WARNING);
            ORM::configure('logging', true);
        }
    }
}
