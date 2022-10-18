<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Exception\NotFoundHttpException;
use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ItemProduct
{
    public function __invoke(Request $request): string
    {
        $id = $request->getAttribute('id');

        $productRepository = new ProductRepository();
        $product = $productRepository->findOneById($id);

        if ($product === null) {
            throw new NotFoundHttpException();
        }

        http_response_code(200);
        header('Content-Type: application/json');

        $serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->serialize($product, 'json');
    }
}
