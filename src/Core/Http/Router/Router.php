<?php

declare(strict_types=1);

namespace App\Core\Http\Router;

use App\Core\Http\Exception\NotFoundHttpException;
use App\Products\Controller\AddProduct;
use App\Products\Controller\ItemProduct;
use App\Products\Controller\ListProducts;
use App\Security\Controller\Connect;
use App\Security\Controller\Disconnect;
use App\Account\Controller\Me;
use App\Account\Controller\UserRegister;
use App\Core\Http\Request;

class Router
{
    /** @var array<Route>  */
    private array $routes = [];

    public function __construct()
    {
        $this->routes['me'] = new Route('/me', 'GET', Me::class);
        $this->routes['login'] = new Route('/login', 'POST', Connect::class);
        $this->routes['logout'] = new Route('/logout', 'POST', Disconnect::class);
        $this->routes['products_add'] = new Route('/products', 'POST', AddProduct::class);
        $this->routes['products_get_collection'] = new Route('/products', 'GET', ListProducts::class);
        $this->routes['products_get_item'] = new Route('/products/(?<id>.*)', 'GET', ItemProduct::class);
        $this->routes['users_add'] = new Route('/users', 'POST', UserRegister::class);
    }

    public function getContent(Request $request): string
    {
        $path = $request->getPath();
        $method = $request->getMethod();

        foreach ($this->routes as $route){
            if ($route->method === $method && preg_match("#^$route->path$#", $path, $matches)){
                foreach ($matches as $key => $match) {
                    // Only store marked paths. example for an id: ^/products/(?<id>.*)$
                    if (is_numeric($key)) {
                        continue;
                    }

                    $request->setAttribute($key, $match);
                }

                return (new $route->controller())($request);
            }
        }

        throw new NotFoundHttpException();
    }
}
