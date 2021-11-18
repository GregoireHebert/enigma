<?php

declare(strict_types=1);

namespace src\Controller;

use src\Http\Response;
use src\Router\Route;
use src\Router\Router;
use src\Templating\Render;

#[Route(path: '/info', name: 'info')]
class Info implements Controller
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
            'content' => (new Render())->render('info'),
        ]);

        $response = new Response($content);
        $response->display();
    }
}
