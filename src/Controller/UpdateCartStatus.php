<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * @Route(path="cart/{id}/update/status", methods={"GET"}, name="cart_status_update")
 * @Security("is_granted('ROLE_MANAGER')")
 */
class UpdateCartStatus extends AbstractController
{
    public function __invoke(RouterInterface $router, Request $request, Cart $cart, Environment $twig, StatusRepository $statusRepository, EntityManagerInterface $entityManager)
    {
        $status = $cart->getStatus();
        $nextStatus = $statusRepository->findOneBy(['level' => $status->getLevel() + 1]);
        $cart->setStatus($nextStatus);
        $entityManager->persist($cart);
        $entityManager->flush();

        return new RedirectResponse($router->generate('carts'));
    }
}
