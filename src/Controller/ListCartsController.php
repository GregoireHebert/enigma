<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Repository\CartRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="carts", name="carts", methods={"GET"})
 */
class ListCartsController
{
    public function __invoke(Environment $twig, CartRepository $cartRepository)
    {
        return new Response($twig->render('cartList.html.twig', [
            'carts' => $cartRepository->findAll(),
            'orderStatusInProgress' => Cart::ORDER_STATUS_IN_PROGRESS,
            'orderStatusReady' => Cart::ORDER_STATUS_READY,
            'orderStatusTake' => Cart::ORDER_STATUS_TAKE
        ]));
    }
}
