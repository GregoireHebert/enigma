<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

class Reference
{
    public function __construct(public string $id)
    {
    }
}
