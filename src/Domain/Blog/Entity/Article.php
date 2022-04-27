<?php

declare(strict_types=1);

namespace App\Domain\Blog\Entity;

use Doctrine\ORM\Mapping\Entity;

#[Entity]
class Article
{
    public string $titre;
    public \DateTime $datePublication;
    public string $auteur;
    public string $contenu;
}
