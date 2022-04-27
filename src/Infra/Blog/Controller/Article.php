<?php

declare(strict_types=1);

namespace App\Infra\Blog\Controller;

use App\Domain\Blog\Entity\Article as ArticleModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route(path: '/articles/{slug}', name: 'article')]
class Article
{
    public function __invoke(Environment $twig)
    {
        $today = new \DateTime();
        $article = new ArticleModel(
            titre: 'Alaphilippe, scandale!',
            datePublication: $today,
            auteur: 'sport.fr',
            contenu: 'j\'étais pas content alors j\'ai freiné.'
        );
        return new Response($twig->render('blog/article.html.twig', ['article' => $article]));
    }
}
