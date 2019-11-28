<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route(path="/products/list", name="products_list", methods={"GET"})
 */
class ListProducts
{
    public function __invoke(Environment $twig, ProductRepository $productRepository)
    {
//        $repository = $entityManager->getRepository(Product::class);
        $products = $productRepository->findAll();
//        $products = $productRepository->getDrinks();

        return new Response($twig->render('listProducts.html.twig', [
            'products' => $products
        ]));
    }
}
