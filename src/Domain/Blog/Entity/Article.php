<?php

declare(strict_types=1);

namespace App\Domain\Blog\Entity;

class Article
{
    public function __construct(
        public string $titre,
        public \DateTime $datePublication,
        public string $auteur,
        public string $contenu
    )
    {
    }
}
