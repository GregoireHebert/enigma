<?php

declare(strict_types=1);

namespace App\Infra\Menu\TwigExtension;

use App\Infra\Menu\Menu;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuExtension extends AbstractExtension
{
    public function __construct(private Menu $menu)
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('menu', [$this, 'getMenu'])
        ];
    }

    public function getMenu(): iterable
    {
        return $this->menu->getLinks();
    }
}
