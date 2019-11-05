<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function __invoke(Request $request): Response
    {
        $name = $request->query->get('name', 'Anonymous');

        return new Response("Hello $name!");
    }
}
