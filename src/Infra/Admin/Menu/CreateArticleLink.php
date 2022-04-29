<?php

declare(strict_types=1);

namespace App\Infra\Admin\Menu;

use App\Infra\Menu\Link;
use Symfony\Component\Routing\RouterInterface;

class CreateArticleLink implements Link
{
    public function __construct(private RouterInterface $router)
    {
    }

    public function getLabel(): string
    {
        return 'Nouveau post';
    }

    public function getPath(): string
    {
        return $this->router->generate('article_create');
    }

    public function getTarget(): string
    {
        return '_self';
    }

    public static function getDefaultPriority(): int
    {
        return 64;
    }
}
