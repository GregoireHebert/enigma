<?php

declare(strict_types=1);

namespace App\Domain\Blog\ArticleDataSource;

use App\Domain\Blog\Entity\Article;
use Symfony\Component\Serializer\SerializerInterface;

class HtmlDataSource implements ArticleDataSourceInterface
{
    private const HTML_DIR = 'ArticlesHtml';

    public function __construct(private string $projectDir, private SerializerInterface $serializer)
    {
    }

    public function getArticle(string $slug): ?Article
    {
        if (file_exists($path = $this->projectDir.'/'.self::HTML_DIR.'/'.$slug.'.html')) {
            $fileContent = file_get_contents($path);

            preg_match('#<script type="application/ld\+json">(?<jsonContent>[\w\W]+)</script>#', $fileContent, $results);
            $jsonContent = $results['jsonContent'];

            return $this->serializer->deserialize($jsonContent, Article::class, 'json');
        }

        return null;
    }
}
