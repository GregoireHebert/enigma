<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Request;
use App\Products\ProductFactory;
use App\Products\Repository\ProductRepository;
use App\Products\Validator\ProductValidator;
use App\Security\Events\SecuredController;
use App\Security\Security;

class AddProduct implements SecuredController
{
    public function __invoke(Request $request)
    {
        $security = new Security();
        $security->hasRole('ROLE_ADMIN');

        $productFactory = new ProductFactory();
        $product = $productFactory->createProductFromRequest($request);

        $productValidator = new ProductValidator();
        $productValidator->validate($product);

        $productRepository = new ProductRepository();
        $productRepository->save($product);

        return $product;
    }
}
