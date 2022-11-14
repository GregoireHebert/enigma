<?php

declare(strict_types=1);

namespace App\Products\Model;

use App\Security\NullUser;
use App\Security\UserInterface;

class NullProduct implements ProductInterface
{
    public function getId(): string
    {
        return 'null';
    }

    public function getEstimation(): int
    {
        return 0;
    }

    public function setEstimation(int $estimation): void
    {
    }

    public function getStartingPrice(): int
    {
        return 0;
    }

    public function setStartingPrice(int $startingPrice): void
    {
    }

    public function getName(): string
    {
        return 'null';
    }

    public function setName(string $name): void
    {
    }

    public function getDescription(): string
    {
        return 'null description';
    }

    public function setDescription(string $description): void
    {
    }

    public function getWinner(): ?UserInterface
    {
        return new NullUser();
    }

    public function getEnd(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }

    public function getProduct(): ProductInterface
    {
        return new NullProduct();
    }

    public function getFinalPrice(): int
    {
        return 0;
    }
}
