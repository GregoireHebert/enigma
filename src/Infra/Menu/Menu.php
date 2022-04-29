<?php

declare(strict_types=1);

namespace App\Infra\Menu;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class Menu
{
    public function __construct(#[TaggedIterator('app.menu.link')]private iterable $links)
    {
    }

    /**
     * @return iterable<Link>
     */
    public function getLinks(): iterable
    {
        return $this->links;
    }
}
