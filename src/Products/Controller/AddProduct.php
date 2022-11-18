<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\DependencyInjection\Container;
use App\Core\Http\Request;
use App\Products\ProductFactory;
use App\Products\Repository\ProductRepository;
use App\Products\Validator\ProductValidator;
use App\Security\Events\SecuredController;
use App\Security\Security;

class AddProduct implements SecuredController
{
    public function __invoke(Request $request, Container $container)
    {
        $security = $container->getService(Security::class);
        $security->hasRole('ROLE_ADMIN');

        $productFactory = $container->getService(ProductFactory::class);
        $product = $productFactory->createProductFromRequest($request);

        $productValidator = $container->getService(ProductValidator::class);
        $productValidator->validate($product);

        $productRepository = $container->getService(ProductRepository::class);
        $productRepository->save($product);

        return $product;
    }
}
