<?php

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
|
*/
$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => TRUE,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8mb4_general_ci',
            'prefix' => ''
        ]
    ]
]);
