<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection;

class ServiceDefinition
{
    public function __construct(
        public readonly string $className,
        public readonly array $arguments = [],
        public ?string $decorated = null
    ) {
    }
}
