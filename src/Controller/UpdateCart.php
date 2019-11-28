<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Form\CreateProductType;
use App\Form\UpdateCartStatus;
use App\Repository\StatusRepository;
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
 * @Route(path="cart/{id}/update", methods={"GET", "POST"}, name="cart_update")
 */
class UpdateCart extends AbstractController
{
    public function __invoke(RouterInterface $router, Request $request, Cart $cart, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, StatusRepository $statusRepository)
    {

        $form = $formFactory->create(UpdateCartStatus::class, $cart);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return new RedirectResponse($router->generate('products_list'));
        }

        return new Response($twig->render('updateCart.html.twig', [
            'status' => $statusRepository->findAll(),
            'form'=> $form->createView()

        ]));
    }
}
