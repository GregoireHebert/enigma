<?php

declare(strict_types=1);

namespace src\Controller;

use src\Http\Response;
use src\Router\Router;
use src\Templating\Render;
use src\Router\Route;

#[Route(path: '/home', name: 'accueil')]
class Home implements Controller
{
    public function __construct(private Router $router)
    {
    }

    public function display(): void
    {
        $content = (new Render())->render('layout', [
            'routeHome' => $this->router->getPath('accueil'),
            'routeInfo' => $this->router->getPath('info'),
            'routeQuery' => $this->router->getPath('query', ['name'=>'greg']),
            'content' => (new Render())->render('home'),
        ]);

        $response = new Response($content);
        $response->display();
    }
}
