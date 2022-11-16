<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use App\Security\Events\SecuredController;
use App\Security\Security;

class DeleteProduct implements SecuredController
{
    public function __invoke(Request $request)
    {
        $security = new Security();
        $security->hasRole('ROLE_ADMIN');

        $id = $request->getAttribute('id');

        $productRepository = new ProductRepository();
        $product = $productRepository->findOneById($id);

        if ($product !== null) {
            $productRepository->remove($product);
        }

        return '';
    }
}
