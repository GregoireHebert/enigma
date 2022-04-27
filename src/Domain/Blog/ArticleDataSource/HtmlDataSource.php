<?php

declare(strict_types=1);

namespace App\Domain\Blog\ArticleDataSource;

use App\Domain\Blog\Entity\Article;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Serializer\SerializerInterface;

class HtmlDataSource implements ArticleDataSourceInterface
{
    private const HTML_DIR = 'ArticlesHtml';

    public function __construct(private string $projectDir, private SerializerInterface $serializer)
    {
    }

    /**
     * @return iterable<Article>
     */
    public function getAll(): iterable
    {
        $finder = Finder::create()->files()->name('*.html')->in($this->projectDir.'/'.self::HTML_DIR);
        foreach ($finder->getIterator() as $file) {
            /** @var $file SplFileInfo */
            yield $this->parse($file->getPathname());
        }
    }

    public function getArticle(string $slug): ?Article
    {
        if (file_exists($path = $this->projectDir.'/'.self::HTML_DIR.'/'.$slug.'.html')) {
            return $this->parse($path);
        }

        return null;
    }

    private function parse(string $path): Article
    {
        $fileContent = file_get_contents($path);

        preg_match('#<script type="application/ld\+json">(?<jsonContent>[\w\W]+)</script>#', $fileContent, $results);
        $jsonContent = $results['jsonContent'];

        return $this->serializer->deserialize($jsonContent, Article::class, 'json');
    }
}
