<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\DependencyInjection\Container;
use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use App\Security\Events\SecuredController;
use App\Security\Security;

class DeleteProduct implements SecuredController
{
    public function __invoke(Request $request, Container $container)
    {
        $security = $container->getService(Security::class);
        $security->hasRole('ROLE_ADMIN');

        $id = $request->getAttribute('id');

        $productRepository = $container->getService(ProductRepository::class);
        $product = $productRepository->findOneById($id);

        if ($product !== null) {
            $productRepository->remove($product);
        }

        return '';
    }
}
