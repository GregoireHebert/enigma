<?php

declare(strict_types=1);

namespace src\Router;

use src\Controller\Home;
use src\Controller\Info;

class Router
{
    /**
     * @var array<Route>
     */
    private array $routes = [];

    public function __construct()
    {
        $this->routes[] = new Route(path: '/home', name: 'accueil', controller: Home::class);
        $this->routes[] = new Route(path: '/info', name: 'info', controller: Info::class);
    }

    public function getPath(string $routeName)
    {
        foreach ($this->routes as $route) {
            if ($route->name === $routeName) {
                return $route->path;
            }
        }
    }

    public function getController(string $pathInfo)
    {
        foreach ($this->routes as $route) {
            if ($route->path === $pathInfo) {
                return $route->controller;
            }
        }
    }
}
