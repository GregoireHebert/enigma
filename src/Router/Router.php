<?php

declare(strict_types=1);

namespace src\Router;

use src\Exception\NotFoundHttpException;
use src\Logger\LoggerAware;

class Router
{
    use LoggerAware;

    private const CONTROLLERS_DIR = __DIR__.'/../Controller';

    /**
     * @var array<Route>
     */
    private array $routes = [];

    public function __construct()
    {
        $this->findControllers();
    }

    /**
     * @param array $queryParameters example ['foo' => 'bar']
     */
    public function getPath(string $routeName, array $queryParameters = [])
    {
        foreach ($this->routes as $route) {
            if ($route->name === $routeName) {
                $queryParametersString = http_build_query($queryParameters);

                if (empty($queryParametersString)) {
                    return $route->path;
                }

                return $route->path.'?'.$queryParametersString;
            }
        }
    }

    public function getController(string $pathInfo)
    {
        foreach ($this->routes as $route) {
            if ($route->path === $pathInfo) {
                $this->log("Controller found '$route->controller' for path $pathInfo");
                return $route->controller;
            }
        }

        $this->log("Controller Not found for path $pathInfo", 'error', ['routes' => $this->routes]);
        throw new NotFoundHttpException();
    }

    public function findControllers()
    {
        if (!is_dir(self::CONTROLLERS_DIR)) {
            throw new \LogicException(self::CONTROLLERS_DIR.' should be a valid directory');
        }

        foreach (scandir(self::CONTROLLERS_DIR) as $file) {
            if ($file === '.' ||  $file === '..') {
                continue;
            }

            $className = 'src\\Controller\\'.substr($file, 0, -4);
            $reflexion = new \ReflectionClass($className);
            $attributes = $reflexion->getAttributes();

            foreach ($attributes as $attribute){
                $route = $attribute->newInstance();

                if ($route instanceof Route) {
                    $route->controller = $className;
                    $this->routes[] = $route;
                }
            }
        }

        if (empty($this->routes)) {
            $this->log('No routes declared', 'error');
            trigger_error('No routes declared', E_USER_WARNING);
        }
    }
}
