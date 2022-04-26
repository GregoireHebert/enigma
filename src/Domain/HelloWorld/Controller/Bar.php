<?php

declare(strict_types=1);

namespace App\Domain\HelloWorld\Controller;

class Bar
{
    public function __invoke()
    {
        return 'bar';
    }
}
