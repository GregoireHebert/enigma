<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Request;
use App\Products\ProductFactory;
use App\Products\Repository\ProductRepository;
use App\Products\Validator\ProductValidator;
use App\Security\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AddProduct
{
    public function __invoke(Request $request): string
    {
        $security = new Security();
        $security->hasRole('ROLE_ADMIN');

        $productFactory = new ProductFactory();
        $product = $productFactory->createProductFromRequest($request);

        $productValidator = new ProductValidator();
        $productValidator->validate($product);

        $productRepository = new ProductRepository();
        $productRepository->save($product);

        http_response_code(201);
        header('Content-Type: application/json');

        $serializer = new Serializer(
            [new DateTimeNormalizer(), new ObjectNormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->serialize($product, 'json');
    }
}
