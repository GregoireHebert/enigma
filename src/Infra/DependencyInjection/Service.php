<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

class Service
{
    /**
     * @param string $class
     * @param array<Reference> $arguments
     */
    public function __construct(public string $class, public array $arguments)
    {
    }
}
