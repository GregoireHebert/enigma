<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Form\CreateProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="/products", methods={"POST", "GET"}, name="products_create")
 */
class CreateProduct
{
    public function __invoke(Request $request, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
    {
        $product = new Product();
        $form = $formFactory->create(CreateProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $entityManager->persist($product);
            $entityManager->flush();
        }

        return new Response($twig->render('createProduct.html.twig', [
            'form' => $form->createView()
        ]));
    }
}
