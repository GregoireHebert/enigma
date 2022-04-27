<?php

declare(strict_types=1);

namespace App\Domain\Blog\ArticleDataSource;

use App\Domain\Blog\Entity\Article;

interface ArticleDataSourceInterface
{
    public function getArticle(string $slug): ?Article;
}
