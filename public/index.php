<?php

declare(strict_types=1);

spl_autoload_register(function(string $className) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php';
    require_once (__DIR__."/../$path");
});

use src\Router\Router;

$router = new Router();
$controllerName = $router->getController($_SERVER['PATH_INFO'] ?? '/home');

$controller = new $controllerName($router);
$controller->display();
