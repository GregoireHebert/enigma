<?php

declare(strict_types=1);

namespace App\Products\Model;

use App\Security\UserInterface;

interface ProductInterface
{
    public function getId(): string;

    public function getEstimation(): int;

    public function setEstimation(int $estimation): void;

    public function getStartingPrice(): int;

    public function setStartingPrice(int $startingPrice): void;

    public function getFinalPrice(): int;

    public function getName(): string;

    public function setName(string $name): void;

    public function getDescription(): string;

    public function setDescription(string $description): void;

    public function getWinner(): ?UserInterface;

    public function getEnd(): \DateTimeImmutable;
}
