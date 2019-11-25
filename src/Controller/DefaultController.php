<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="default", path="/default")
 */
class DefaultController
{
    public function __invoke(): Response
    {
        return new Response('Hola Que tal?');
    }
}
