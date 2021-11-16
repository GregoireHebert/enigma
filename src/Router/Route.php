<?php

declare(strict_types=1);

namespace src\Router;

class Route
{
    public function __construct(public string $path,public string  $name,public string  $controller)
    {
    }
}
