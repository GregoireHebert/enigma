<?php

declare(strict_types=1);

namespace App\Infra\Routing;

use App\Domain\Errors\Controller\Error404;
use App\Domain\HelloWorld\Controller\World;
use App\Domain\HelloWorld\Controller\Bar;

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [
            '/' => World::class,
            '/bar' => Bar::class,
            '/404' => Error404::class,
        ];
    }

    public function getController(string $path): callable
    {
        $class = $this->routes[$path] ?? $this->routes['/404'];

        return new $class;
    }
}
