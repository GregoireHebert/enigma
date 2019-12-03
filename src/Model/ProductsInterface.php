<?php

declare(strict_types=1);

namespace App\Model;

interface ProductsInterface
{
    public function getId(): int;
    public function setId(int $id): void;
    public function getName(): String;
    public function setName(String $name): String;
    public function getPrice(): int;
    public function setPrice(int $price): int;
    public function getCategories(): array;
    public function setCategories(array $categories): void;
    public function addCategory(Categories $categorie): void;
    public function removeCategory(Categories $categorie): void;
}
