<?php

declare(strict_types=1);

namespace App\Bid\Model;

use App\Products\Model\ProductInterface;
use App\Security\UserInterface;

class Bid implements BidInterface
{
    public function __construct(
        public readonly string $id,
        public readonly ProductInterface $product,
        public readonly UserInterface $user,
        public readonly int $amount,
        public readonly \DateTimeImmutable $datetime,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProductStartingPrice(): int
    {
        return $this->product->getStartingPrice();
    }

    public function getProductEstimation(): int
    {
        return $this->product->getEstimation();
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
        return $this->amount;
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
