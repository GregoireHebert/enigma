<?php

declare(strict_types=1);

namespace src\Router;

#[\Attribute]
class Route
{
    public function __construct(public string $path, public string $name, public string $controller = '')
    {
    }
}
