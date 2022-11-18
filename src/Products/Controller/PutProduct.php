<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\DependencyInjection\Container;
use App\Core\Http\Exception\NotFoundHttpException;
use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use App\Products\Validator\ProductValidator;
use App\Security\Events\SecuredController;
use App\Security\Security;

class PutProduct implements SecuredController
{
    public function __invoke(Request $request, Container $container)
    {
        $security = $container->getService(Security::class);
        $security->hasRole('ROLE_ADMIN');

        $id = $request->getAttribute('id');

        $productRepository = $container->getService(ProductRepository::class);
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

        $productValidator = $container->getService(ProductValidator::class);
        $productValidator->validate($product);

        $productRepository = $container->getService(ProductRepository::class);
        $productRepository->save($product);

        return $product;
    }
}
