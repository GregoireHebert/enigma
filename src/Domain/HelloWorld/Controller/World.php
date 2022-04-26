<?php

declare(strict_types=1);

namespace App\Domain\HelloWorld\Controller;

use App\Infra\DependencyInjection\Container;
use App\Infra\Http\Request;
use App\Infra\Http\Response;

class World
{
    public function __invoke(Container $container): Response
    {
        $request = $container->get(Request::class);
        $name = $request->getQuery('name', 'anonymous');

        return new Response('world '.$name);
    }
}
