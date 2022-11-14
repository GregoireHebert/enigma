<?php

declare(strict_types=1);

namespace App\Command;

use App\Bid\Repository\BidRepository;
use App\Products\Repository\ProductRepository;
use App\Security\Repository\UserRepository;

class GetWinners
{
    public function execute(): void
    {
        $productsRepository = new ProductRepository();
        $bidsRepository = new BidRepository();

        $finishedBids = $productsRepository->getFinishedBids();

        foreach ($finishedBids as $finishedBid) {
            if (null === $winner = $bidsRepository->getWinner($finishedBid)) {
                continue;
            }

            $finishedBid->setFinalPrice($winner->amount);
            $finishedBid->setWinner($winner->winner);

            echo sprintf('Winner is %s, for product %s, at %s€'.PHP_EOL, $winner->winner->getUsername(), $finishedBid->getName(), $winner->amount);

            $productsRepository->save($finishedBid);
        }

        exit(0);
    }
}
