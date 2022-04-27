<?php

declare(strict_types=1);

namespace App\Domain\Blog\ArticleDataSource;

use App\Domain\Blog\Entity\Article;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class MarkdownDataSource implements ArticleDataSourceInterface
{
    private const MARKDOWN_DIR = 'ArticlesMarkdown';

    public function __construct(
        private string $projectDir,
        private MarkdownParserInterface $markdownParser,
        private ObjectNormalizer $normalizer
    )
    {
    }

    public function getArticle(string $slug): ?Article
    {
        if (file_exists($path = $this->projectDir.'/'.self::MARKDOWN_DIR.'/'.$slug.'.md')) {
            $fileContent = file_get_contents($path);

            [$headers, $markdown] = str_split($fileContent, strpos($fileContent, PHP_EOL.PHP_EOL));

            $article = [];

            foreach (explode(PHP_EOL, $headers) as $header){
                [$key, $value] = explode('=', $header);
                $article[$key] = trim($value);
            }

            $article['contenu'] = $this->markdownParser->transformMarkdown($markdown);

            return $this->normalizer->denormalize($article, Article::class, 'array');
        }

        return null;
    }
}
