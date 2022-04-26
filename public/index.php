<?php

declare(strict_types=1);

spl_autoload_register(static function(string $fqcn) {
    $filePath = str_replace(['\\', 'App'], ['/', 'src'], $fqcn).'.php';
    require_once(__DIR__.'/../'.$filePath);
});

use App\Infra\Http\Request;
use App\Infra\Routing\Router;

$request = Request::createFromGlobals();
$router = new Router();

$controller = $router->getController($request->getPath());

$response = $controller();
echo $response;
