<?php

declare(strict_types=1);

spl_autoload_register(function(string $className) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php';
    require_once (__DIR__."/../$path");
});

use src\Router\Router;
use src\Exception\NotFoundHttpException;
use src\Http\Response;

$router = new Router();

try {
    $controllerName = $router->getController($_SERVER['PATH_INFO'] ?? '/home');
    $controller = new $controllerName($router);
    $controller->display();
} catch(NotFoundHttpException $exception) {

    $routeHome = $router->getPath('accueil');
    $routeInfo = $router->getPath('info');
    $routeQuery = $router->getPath('query', ['name'=>'greg']);

    $content = <<<HTML
<html>
    <head>
        <title>Mon super site</title>    
    </head>
    <body>
        <h1>Mon super site !</h1>
        <p>
            <a href="$routeHome">Home</a>
            <a href="$routeInfo">Info</a>
            <a href="$routeQuery">Query</a>
        </p>
        <p>
            404 Not Found
        </p>
    </body>
</html>
HTML;

    $response = new Response($content, 404);
    $response->display();

} catch(Exception $exception) {
    $response = new Response('', 500);
    $response->display();
}
