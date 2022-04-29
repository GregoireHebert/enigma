<?php

declare(strict_types=1);

namespace App\Infra\Blog\Menu;

use App\Infra\Menu\Link;
use Symfony\Component\Routing\RouterInterface;

class HomeLink implements Link
{
    public function __construct(private RouterInterface $router)
    {
    }

    public function getLabel(): string
    {
        return 'Accueil';
    }

    public function getPath(): string
    {
        return $this->router->generate('home');
    }

    public function getTarget(): string
    {
        return '_self';
    }

    public static function getDefaultPriority(): int
    {
        return 999;
    }
}
