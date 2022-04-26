<?php

declare(strict_types=1);

namespace App\Infra\Http;

class Request
{
    public function __construct(private string $path)
    {
    }

    public static function createFromGlobals(): Request
    {
        return new self(
            $_SERVER['PATH_INFO'] ?? '/'
        );
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
