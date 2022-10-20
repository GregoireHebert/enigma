<?php

declare(strict_types=1);

namespace App\Products\Controller;

use App\Core\Http\Exception\NotFoundHttpException;
use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use App\Products\Validator\ProductValidator;
use App\Security\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PutProduct
{
    public function __invoke(Request $request): string
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

        http_response_code(200);
        header('Content-Type: application/json');

        $serializer = new Serializer(
            [new DateTimeNormalizer(), new ObjectNormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->serialize($product, 'json');
    }
}
