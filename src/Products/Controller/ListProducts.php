<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ListProducts
{
    public function __invoke(Request $request)
    {
        $productRepository = new ProductRepository();
        $products = $productRepository->findAll();

        http_response_code(200);
        header('Content-Type: application/json');

        $serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->serialize($products, 'json');
    }
}
