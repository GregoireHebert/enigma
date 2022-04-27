<?php

declare(strict_types=1);

namespace App\Infra\Blog\Controller;

use App\Domain\Blog\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route(path: '/articles')]
class Articles
{
    public function __construct(private Environment $twig)
    {}

    public function __invoke()
    {
        $today = new \DateTime();
        $articles=  [
            new Article(
              titre: 'Alaphilippe, scandale!',
              datePublication: $today,
              auteur: 'sport.fr',
              contenu: 'j\'étais pas content alors j\'ai freiné.'
            ),
            new Article(
                titre: 'Alaphilippe, scandale!',
                datePublication: $today,
                auteur: 'sport.fr',
                contenu: 'j\'étais pas content alors j\'ai freiné.'
            )
        ];

        return new Response($this->twig->render('blog/articles.html.twig', ['articles'=>$articles]));
    }
}
