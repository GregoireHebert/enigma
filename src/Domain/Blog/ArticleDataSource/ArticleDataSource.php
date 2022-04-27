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

    /**
     * @return array<Article>
     */
    public function getAll(): iterable
    {
        foreach ($this->sources as $source) {
            foreach ($source->getAll() as $article){
                if ($article === null) {
                    continue;
                }

                yield $article;
            }
        }
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
