<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Exception\NotFoundHttpException;
use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use App\Products\Validator\ProductValidator;
use App\Security\Events\SecuredController;
use App\Security\Security;

class PutProduct implements SecuredController
{
    public function __invoke(Request $request)
    {
        $security = new Security();
        $security->hasRole('ROLE_ADMIN');

        $id = $request->getAttribute('id');

        $productRepository = new ProductRepository();
        $product = $productRepository->findOneById($id);

        if ($product === null) {
            throw new NotFoundHttpException();
        }

        foreach ($request->getRequests() as $propertyName => $propertyValue) {
            // TODO handle not accessible methods and public properties
            $methodName = sprintf('set%s', ucfirst($propertyName));
            if (method_exists($product, $methodName)) {
                if ($propertyName === 'end') {
                    $propertyValue = new \DateTimeImmutable($propertyValue);
                }

                $product->$methodName($propertyValue);
            }
        }

        $productValidator = new ProductValidator();
        $productValidator->validate($product);

        $productRepository = new ProductRepository();
        $productRepository->save($product);

        return $product;
    }
}