<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Exception\NotFoundHttpException;
use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;

class ItemProduct
{
    public function __invoke(Request $request)
    {
        $id = $request->getAttribute('id');

        $productRepository = new ProductRepository();
        $product = $productRepository->findOneById($id);

        if ($product === null) {
            throw new NotFoundHttpException();
        }

        return $product;
    }
}
