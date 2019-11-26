<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Form\CreateProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * @Route(path="products/{id}/update", methods={"GET", "POST"}, name="products_update")
 */
class UpdateProduct
{
    public function __invoke(RouterInterface $router, Request $request, Product $product, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
    {
        $form = $formFactory->create(CreateProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return new RedirectResponse($router->generate('products_list'));
        }

        return new Response($twig->render('updateProduct.html.twig', [
            'form' => $form->createView()
        ]));
    }
}
