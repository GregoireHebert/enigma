<?php

declare(strict_types=1);

namespace App\Domain\HelloWorld\Controller;

use App\Infra\Http\Request;
use App\Infra\Http\Response;

class World
{
    public function __construct(private Request $request)
    {
    }

    public function __invoke(): Response
    {
        $name = $this->request->getQuery('name', 'anonymous');

        return new Response('world '.$name);
    }
}
