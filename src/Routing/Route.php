<?php

declare(strict_types=1);

namespace App\Routing;

class Route
{
    public function __construct(public string $routeName, public string $path, public string $controller)
    {
    }
}
