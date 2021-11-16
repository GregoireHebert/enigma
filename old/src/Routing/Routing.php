<?php

declare(strict_types=1);

namespace App\Routing;

class Routing
{
    /** @var array<Route> */
    private array $routes = [];

    public function addRoute(string $routeName, string $path, string $controller): void
    {
        $this->routes[] = new Route($routeName, $path, $controller);
    }

    public function get($argName, $default = null): string
    {
        return $_GET[$argName] ?? $_POST[$argName] ?? $default;
    }

    public function getPath(string $routeName, array $args = []): string
    {
        $queryParameters = empty($args) ? '' : '?'.http_build_query($args);

        foreach ($this->routes as $route) {
            if ($route->routeName === $routeName) {
                return $route->path.$queryParameters;
            }
        }

        throw new \NotFoundException("Tried to generate path for route $routeName but such route does not exists");
    }

    public function getController(): string
    {
        foreach ($this->routes as $route) {
            if ($route->path === ($_SERVER['PATH_INFO'] ?? '/')) {
                return $route->controller;
            }
        }

        throw new \NotFoundException("Route $route but such route does not exists");
    }
}
