<?php

declare(strict_types=1);

namespace App\Core\Http;

final class Request
{
    private function __construct(
        private array $post,
        private string $path,
        private string $method
    )
    {
    }

    public static function createFromGlobals(): self
    {
        return new self(
            $_POST,
            $_SERVER['PATH_INFO'] ?? '/',
            $_SERVER['REQUEST_METHOD'] ?? 'GET'
        );
    }

    public function getRequest(string $name, $default = null): mixed
    {
        return $this->post[$name] ?? $default;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
