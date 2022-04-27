<?php

declare(strict_types=1);

namespace App\Domain\Blog\ArticleDataSource;

use App\Domain\Blog\Entity\Article;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
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

    /**
     * @return iterable<Article>
     */
    public function getAll(): iterable
    {
        $finder = Finder::create()->files()->name('*.md')->in($this->projectDir.'/'.self::MARKDOWN_DIR);
        foreach ($finder->getIterator() as $file) {
            /** @var $file SplFileInfo */
            yield $this->parse($file->getPathname());
        }
    }

    public function getArticle(string $slug): ?Article
    {
        if (file_exists($path = $this->projectDir.'/'.self::MARKDOWN_DIR.'/'.$slug.'.md')) {
            return $this->parse($path);
        }

        return null;
    }

    private function parse(string $path): Article
    {
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
}
