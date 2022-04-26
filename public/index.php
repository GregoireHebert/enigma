<?php

declare(strict_types=1);

$path = $_SERVER['PATH_INFO'] ?? '/';
echo '<pre>';
var_dump($path);
echo '</pre>';

if ($path === '/') {
    echo 'World';
}

if ($path === '/bar') {
    echo 'Bar';
}

php -S localhost:8000 -t public
