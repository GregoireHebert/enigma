<?php

declare(strict_types=1);

namespace App\Core\Http\Router;

final class Route
{
    public function __construct(
        public readonly string $path,
        public readonly string $method,
        public readonly string $controller
    ) {
    }
}
