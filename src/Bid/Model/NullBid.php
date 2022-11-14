<?php

declare(strict_types=1);

namespace App\Bid\Model;

use App\Products\Model\NullProduct;
use App\Products\Model\ProductInterface;
use App\Security\NullUser;
use App\Security\UserInterface;

class NullBid implements BidInterface
{
    public function __construct(
        public readonly string $id = 'null',
        public readonly ProductInterface $product = new NullProduct(),
        public readonly UserInterface $user = new NullUser(),
        public readonly int $amount = 0,
        public readonly \DateTimeImmutable $datetime = new \DateTimeImmutable(),
    ) {
    }

    public function getId(): string
    {
        return 'null';
    }

    public function getProductStartingPrice(): int
    {
        return 0;
    }

    public function getProductEstimation(): int
    {
        return 0;
    }

    public function getProductEnd(): \DateTimeImmutable
    {
        return $this->product->getEnd();
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getAmount(): int
    {
        return 0;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getDateTime(): \DateTimeImmutable
    {
        return $this->datetime;
    }
}
