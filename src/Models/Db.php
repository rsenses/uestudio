<?php

namespace Expomark\Models;

use ORM;
use Illuminate\Database\Capsule\Manager as Capsule;

class Db
{
    public function __construct($dbDriver, $dbHost, $dbPort, $dbName, $dbUser, $dbPass, $set = true)
    {
        // IdiORM Configuration
        if ($dbDriver === 'sqlite') {
            ORM::configure('connection_string', $dbDriver.':'.$GLOBALS['env']['paths']['sqlite'].$dbName.'.sqlite');
        } else {
            ORM::configure('connection_string', $dbDriver.':host='.$dbHost.';dbname='.$dbName.';port='.$dbPort);
            ORM::configure('username', $dbUser);
            ORM::configure('password', $dbPass);
            if ($dbDriver === 'mysql') {
                ORM::configure('driver_options', array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            }
        }

        if ($set) {
            ORM::configure('return_result_sets', false);
        }

        if ($GLOBALS['env']['debug']) {
            ORM::configure('error_mode', \PDO::ERRMODE_WARNING);
            ORM::configure('logging', true);
        }
    }

    public function memcached($ttl = 3600)
    {
        ORM::configure('caching', true);
        ORM::configure('caching_auto_clear', true);

        $memcached = new \Memcached();
        $memcached->setOption(\Memcached::OPT_DISTRIBUTION, \Memcached::DISTRIBUTION_CONSISTENT);
        $memcached->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
        $memcached->addServers($GLOBALS['env']['memcached']);
        ORM::configure('cache_query_result', function ($cacheKey, $value) use ($memcached, $ttl) {
            $memcached->set($cacheKey, $value, $ttl);
        });
        ORM::configure('check_query_cache', function ($cacheKey) use ($memcached) {
            return $memcached->get($cacheKey);
        });
        ORM::configure('clear_cache', function () use ($memcached) {
            $memcached->flush();
        });
        ORM::configure('create_cacheKey', function ($query, $parameters) {
            $parameterString = implode(',', $parameters);
            $key = $query.':'.$parameterString;
            $myKey = $GLOBALS['config']['info']['session_name'].crc32($key);

            return $myKey;
        });
    }
}
