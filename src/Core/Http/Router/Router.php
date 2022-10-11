<?php

declare(strict_types=1);

namespace App\Core\Http\Router;

use App\Controller\Connect;
use App\Controller\Disconnect;
use App\Controller\Me;
use App\Controller\UserRegister;
use App\Core\Http\Request;

class Router
{
    public function getContent(Request $request): string
    {
        $path = $request->getPath();
        $method = $request->getMethod();

        if ($path === '/') {
            return '<h1>HOME</h1>';
        }

        if ($path === '/users' && $method === 'POST') {
            return (new UserRegister())($request);
        }

        if ($path === '/login' && $method === 'POST') {
            return (new Connect())($request);
        }

        if ($path === '/logout' && $method === 'POST') {
            return (new Disconnect())($request);
        }

        if ($path === '/me' && $method === 'GET') {
            return (new Me())($request);
        }

        return '<h1>OUPS</h1>';
    }
}
