<?php


namespace App\Controller;


use App\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class UpdateCartStatus
 * @package App\Controller
 *
 * @Route(path="carts/{id}/update_status", methods={"GET", "POST"}, name="cart_status_update")
 */
class UpdateCartStatus extends AbstractController
{
    public function __invoke(Request $request, Environment $twig, Cart $cart)
    {
        return new Response(
            $twig->render(
                'updateCartStatus.html.twig',
                [
                    'cart' => $cart
                ]
            )
        );
    }
}