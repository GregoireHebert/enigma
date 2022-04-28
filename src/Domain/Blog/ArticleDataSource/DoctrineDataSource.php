<?php

declare(strict_types=1);

namespace App\Domain\Blog\ArticleDataSource;

use App\Domain\Blog\Entity\Article;
use App\Domain\Blog\Repository\ArticleRepository;

class DoctrineDataSource implements ArticleDataSourceInterface
{
    public function __construct(private ArticleRepository $articleRepository)
    {
    }

    public function getArticle(string $slug): ?Article
    {
        return $this->articleRepository->find($slug);
    }

    public function getAll(): iterable
    {
        return $this->articleRepository->findAll();
    }
}
