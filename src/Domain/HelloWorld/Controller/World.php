<?php

declare(strict_types=1);

namespace App\Domain\HelloWorld\Controller;

class World
{
    public function __invoke()
    {
        return 'world';
    }
}
