<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Categories as AppCategories;

class Categories implements AppCategories
{
    private $name;
    private $id;

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
