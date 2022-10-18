<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Exception\NotFoundHttpException;
use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use App\Products\Validator\ProductValidator;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DeleteProduct
{
    public function __invoke(Request $request)
    {
        $id = $request->getAttribute('id');

        $productRepository = new ProductRepository();
        $product = $productRepository->findOneById($id);

        if ($product !== null) {
            $productRepository->remove($product);
        }

        http_response_code(204);
        return '';
    }
}
