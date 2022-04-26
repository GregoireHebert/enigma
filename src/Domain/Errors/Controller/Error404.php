<?php

declare(strict_types=1);

namespace App\Domain\Errors\Controller;

use App\Infra\Http\Response;

class Error404
{
    public function __invoke(): Response
    {
        return new Response('Error 404 ! la page demandée n\'existe pas');
    }
}
