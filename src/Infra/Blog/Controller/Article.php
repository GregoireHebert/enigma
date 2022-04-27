<?php

declare(strict_types=1);

namespace App\Infra\Blog\Controller;

use App\Domain\Blog\ArticleDataSource\ArticleDataSource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[Route(path: '/articles/{slug}', name: 'article')]
class Article
{
    public function __invoke(Environment $twig, ArticleDataSource $articleDataSource, string $slug)
    {
        $article = $articleDataSource->getArticle($slug);

        if ($article === null) {
            throw new NotFoundHttpException();
            //return new Response('', 404);
        }

        return new Response($twig->render('blog/article.html.twig', ['article' => $article]));
    }
}
