<?php

declare(strict_types=1);

namespace App\Products\Model;

use App\Security\User;
use App\Security\UserInterface;

class Product implements ProductInterface
{
    public function __construct(
        public readonly string $id,
        private ?UserInterface $winner = null,
        private \DateTimeImmutable $end = new \DateTimeImmutable(),
        private int $estimation = 0,
        private int $startingPrice = 0,
        private int $finalPrice = 0,
        private string $name = '',
        private string $description = '',
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEstimation(): int
    {
        return $this->estimation;
    }

    public function setEstimation(int $estimation): void
    {
        $this->estimation = $estimation;
    }

    public function getStartingPrice(): int
    {
        return $this->startingPrice;
    }

    public function setStartingPrice(int $startingPrice): void
    {
        $this->startingPrice = $startingPrice;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getWinner(): ?UserInterface
    {
        return $this->winner;
    }

    public function setWinner(UserInterface $winner): void
    {
        $this->winner = $winner;
    }

    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }

    public function setEnd(\DateTimeImmutable $end): void
    {
        $this->end = $end;
    }

    public function getFinalPrice(): int
    {
        return $this->finalPrice;
    }

    public function setFinalPrice(int $finalPrice): void
    {
        $this->finalPrice = $finalPrice;
    }
}
