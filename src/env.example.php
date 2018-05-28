<?php
#configurations file
$GLOBALS['env'] = [
    'debug' => true,
    'db' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'ueformaciononline',
        'user' => 'root',
        'pass' => 'passs',
    ],
    'azure' => array(
        'enable' => true,
        'blob' => array(
            'AccountName' => 'uecluster',
            'AccountKey' => 'KEY',
        )
    )
];