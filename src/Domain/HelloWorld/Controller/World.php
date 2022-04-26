<?php

declare(strict_types=1);

namespace App\Domain\HelloWorld\Controller;

use App\Infra\Http\Response;

class World
{
    public function __invoke(): Response
    {
        return new Response('world');
    }
}
