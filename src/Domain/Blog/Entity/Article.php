<?php

declare(strict_types=1);

namespace App\Domain\Blog\Entity;

use App\Domain\Blog\Repository\ArticleRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints\Length;

#[Entity(repositoryClass: ArticleRepository::class)]
#[UniqueEntity('titre')]
class Article
{
    #[Id]
    #[Column]
    public string $slug;
    #[Column]
    #[Length(min: 3)]
    private string $titre;
    #[Column(type: 'datetime')]
    public \DateTime $datePublication;
    #[Column]
    #[Length(min: 1)]
    public string $auteur;
    #[Column]
    public string $contenu;

    public function __construct()
    {
        $this->datePublication = new \DateTime();
    }

    public function setTitre(string $titre)
    {
        $this->titre = $titre;
        $this->slug = (new AsciiSlugger())->slug($titre)->toString();
    }

    public function getTitre()
    {
        return $this->titre;
    }
}
