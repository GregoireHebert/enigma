<?php

declare(strict_types=1);

namespace App\Bid\Model;

use App\Products\Model\ProductInterface;
use App\Security\UserInterface;

interface BidInterface
{
    public function getId(): string;

    public function getProductStartingPrice(): int;

    public function getProductEstimation(): int;

    public function getProductEnd(): \DateTimeImmutable;

    public function getAmount(): int;

    public function getUser(): UserInterface;

    public function getDateTime(): \DateTimeImmutable;

    public function getProduct(): ProductInterface;
}
