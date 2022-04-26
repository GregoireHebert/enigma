<?php

declare(strict_types=1);

namespace App\Infra\Http;

class Request
{
    public function __construct(private string $path, private array $get)
    {
    }

    public static function createFromGlobals(): Request
    {
        return new self(
            $_SERVER['PATH_INFO'] ?? '/',
            $_GET
        );
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(string $name, $default = null)
    {
        return $this->get[$name] ?? $default;
    }
}
