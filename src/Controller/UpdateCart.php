<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Response;

class UpdateCart
{
    /**
     * @Route(path="carts/{id}/update", name="update_cart", methods={"POST"})
     */
    public function __invoke(RouterInterface $router, Request $request)
    {
        //data = $request->request->get('form');
        //return new RedirectResponse($router->generate('carts'));
        return new Response(json_encode($request));
    }
}