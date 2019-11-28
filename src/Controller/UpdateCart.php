<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Form\CreateProductType;
use App\Repository\CartRepository;
use App\Voters\ProductResponsibilityVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * @Route(path="carts/{id}/update/{status}", methods={"POST", "GET"}, name="cart_update")
 */
class UpdateCart extends AbstractController
{
    public function __invoke(RouterInterface $router, CartRepository $cartRepository, Cart $cart, string $status)
    {
        $cartRepository->updateCart($cart->getId(), $status);
        return new RedirectResponse($router->generate('carts'));
    }
}
