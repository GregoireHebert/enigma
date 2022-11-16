<?php

declare(strict_types=1);

namespace App\Bid\Controller;

use App\Bid\BidFactory;
use App\Bid\Repository\BidRepository;
use App\Bid\Validator\BidValidator;
use App\Core\Http\Exception\NotFoundHttpException;
use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use App\Security\Events\SecuredController;
use App\Security\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BidProduct implements SecuredController
{
    public function __invoke(Request $request)
    {
        // from /me
        $security = new Security();
        $user = $security->getUser();

        // from /itemProduct
        $id = $request->getAttribute('id');

        $productRepository = new ProductRepository();
        $product = $productRepository->findOneById($id);

        if ($product === null) {
            throw new NotFoundHttpException();
        }

        $bidFactory = new BidFactory();
        $bid = $bidFactory->createBidFromRequest($product, $user, $request);

        $bidValidator = new BidValidator();
        $bidValidator->validate($bid);

        $bidRepository = new BidRepository();
        $bidRepository->save($bid);

        return $bid;

//        http_response_code(201);
//        header('Content-Type: application/json');
//
//        $serializer = new Serializer(
//            [new ObjectNormalizer()],
//            [new JsonEncoder()]
//        );
//
//        return $serializer->serialize($bid, 'json');
    }
}
