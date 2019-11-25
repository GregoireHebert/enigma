<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(name="default", path="/default")
 */
class DefaultController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $name = $request->query->get('name', 'Anonymous');

        return new Response("Hola $name Que tal?");
    }
}
