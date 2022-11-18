<?php

declare(strict_types=1);

namespace App\Bid\Controller;

use App\Bid\BidFactory;
use App\Bid\Repository\BidRepository;
use App\Bid\Validator\BidValidator;
use App\Core\DependencyInjection\Container;
use App\Core\Http\Exception\NotFoundHttpException;
use App\Core\Http\Request;
use App\Products\Repository\ProductRepository;
use App\Security\Events\SecuredController;
use App\Security\Security;

class BidProduct implements SecuredController
{
    public function __invoke(Request $request, Container $container)
    {
        // from /me
        $security = $container->getService(Security::class);
        $user = $security->getUser();

        // from /itemProduct
        $id = $request->getAttribute('id');

        $productRepository = $container->getService(ProductRepository::class);
        $product = $productRepository->findOneById($id);

        if ($product === null) {
            throw new NotFoundHttpException();
        }

        $bidFactory = $container->getService(BidFactory::class);
        $bid = $bidFactory->createBidFromRequest($product, $user, $request);

        $bidValidator = $container->getService(BidValidator::class);
        $bidValidator->validate($bid);

        $bidRepository = $container->getService(BidRepository::class);
        $bidRepository->save($bid);

        return $bid;
    }
}
