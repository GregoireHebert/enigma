<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CartRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="carts", name="carts", methods={"GET"})
 */
class ListCartsController
{
    public function __invoke(Request $request, Environment $twig, CartRepository $cartRepository)
    {
        $label = $request->get('state');

        $carts = $label ? $cartRepository->findByState($label) : $cartRepository->findAll();

        return new Response($twig->render('cartList.html.twig', [
            'carts' => $carts,
            'filterLabel' => $label
        ]));
    }
}
