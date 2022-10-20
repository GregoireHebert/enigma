<?php

declare(strict_types=1);

namespace App\Bid;

use App\Bid\Model\Bid;
use App\Core\Http\Request;
use App\Products\Model\ProductInterface;
use App\Security\UserInterface;
use Symfony\Component\Uid\Uuid;

class BidFactory
{
    public function createBidFromRequest(ProductInterface $product, UserInterface $user, Request $request): Bid
    {
        $amount = $request->getRequest('amount', 0);
        $dateTime = new \DateTimeImmutable();

        return new Bid(
            (string) Uuid::v4(),
            $product,
            $user,
            $amount,
            $dateTime
        );
    }
}
