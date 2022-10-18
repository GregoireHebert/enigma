<?php

declare(strict_types=1);

namespace App\Products\Model;

class Product
{
    public function __construct(
        public readonly string $id,
        private int $estimation = 0,
        private int $startingPrice = 0,
        private string $name = '',
        private string $description = '')
    {
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
}
