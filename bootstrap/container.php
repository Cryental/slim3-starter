<?php

use Illuminate\Database\Capsule\Manager;
use Slim\Views\Twig;
use Dopesong\Slim\Error\Whoops as WhoopsError;

/*
|--------------------------------------------------------------------------
| Init APP Container
|--------------------------------------------------------------------------
|
*/
$container = $app->getContainer();

/*
|--------------------------------------------------------------------------
| Set up View Engine
|--------------------------------------------------------------------------
|
*/
$container['view'] = function ($container) {

    $view = new Twig([__DIR__ . '/../resources/views',
        __DIR__ . '/../resources/views/layout'], [
        //'cache' => __DIR__ . '/../cached/twig/'
        'cache' => FALSE
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->getEnvironment()->addGlobal("session", $_SESSION);

    return $view;
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c->view->render($response, '404.twig');
    };
};

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c->view->render($response, '405.twig');
    };
};

/*
|--------------------------------------------------------------------------
| Error Handler
|--------------------------------------------------------------------------
|
*/
if ($container['settings']['displayErrorDetails'] == FALSE) {
    $container['errorHandler'] = function ($c) {
        return function ($request, $response, $exception) use ($c) {
            return $response->withStatus(500)
                ->withHeader('Content-Type', 'text/plain')
                ->write('Something went wrong. Please try later!');
        };
    };
}

if ($container['settings']['displayErrorDetails'] == TRUE) {
    $container['phpErrorHandler'] = $container['errorHandler'] = function($c) {
        return new WhoopsError();
    };
}

/*
|--------------------------------------------------------------------------
| Global Database Connection
|--------------------------------------------------------------------------
|
*/
$capsule = new Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};
