<?php

declare(strict_types=1);

namespace App\Domain\Blog\ArticleDataSource;

use App\Domain\Blog\Entity\Article;

class ArticleDataSource
{
    /**
     * @var array<ArticleDataSourceInterface>
     */
    private array $sources;

    public function __construct(iterable $sources)
    {
        $this->sources = (array) $sources;
    }

    public function getArticle(string $slug): ?Article
    {
        foreach ($this->sources as $source) {
            $article = $source->getArticle($slug);

            if ($article instanceof Article) {
                return $article;
            }
        }

        return null;
    }
}
