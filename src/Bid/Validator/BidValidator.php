<?php

declare(strict_types=1);

namespace App\Bid\Validator;

use App\Bid\Model\Bid;
use App\Bid\Repository\BidRepository;
use App\Core\Validator\Validator;

/**
 * @implements \App\Core\Validator\Validator<Bid>
 */
class BidValidator implements Validator
{
    public function validate(object $object): void
    {
        if (!$object instanceof Bid) {
            throw new \LogicException('Expected '.Bid::class.' object got '.$object::class);
        }

        $bidRepository = new BidRepository();
        $highestBid = $bidRepository->getHighestBidForProduct($object->product);
        $startingPrice = $object->getProductStartingPrice();
        $today = new \DateTimeImmutable();

        assert($object->getAmount() > $startingPrice, new \App\Core\Validator\ConstraintViolation('amount', "Amount must be higher than the starting selling price ($startingPrice)."));
        assert($object->getAmount() > $highestBid->getAmount(), new \App\Core\Validator\ConstraintViolation('amount', 'Amount must be higher than the highest bid.'));
        assert($object->getUser()->getId() !== $highestBid->getUser()->getId(), new \App\Core\Validator\ConstraintViolation('user', 'You are already the higher bidder.'));
        assert($object->getProductEnd() > $today, new \App\Core\Validator\ConstraintViolation('product', 'You cannot bid when the delay is passed.'));
    }
}
