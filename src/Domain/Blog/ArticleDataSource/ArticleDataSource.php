<?php

declare(strict_types=1);

namespace App\Domain\Blog\ArticleDataSource;

use App\Domain\Blog\Entity\Article;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class ArticleDataSource
{
    /**
     * @var iterable<ArticleDataSourceInterface>
     */
    private iterable $sources;

    public function __construct(#[TaggedIterator('app.article_data_source')] iterable $sources)
    {
        $this->sources = $sources;
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
