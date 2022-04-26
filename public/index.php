<?php

declare(strict_types=1);

spl_autoload_register(static function(string $fqcn) {
    $filePath = str_replace(['\\', 'App'], ['/', 'src'], $fqcn).'.php';
    require_once(__DIR__.'/../'.$filePath);
});

use App\Infra\Http\Request;

$request = Request::createFromGlobals();
$path = $request->getPath();

if ($path === '/') {
    echo 'World';
}

if ($path === '/bar') {
    echo 'Bar';
}
