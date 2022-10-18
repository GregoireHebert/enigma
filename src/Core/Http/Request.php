<?php

declare(strict_types=1);

namespace App\Core\Http;

final class Request
{
    private array $attributes = [];

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

    public function setAttribute(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function getAttribute(string $name, $default = null): mixed
    {
        return $this->attributes[$name] ?? $default;
    }

    public function getRequest(string $name, $default = null): mixed
    {
        return $this->post[$name] ?? $default;
    }

    public function getContent(): string
    {
        $resource = fopen('php://input', 'rb');

        return stream_get_contents($resource) ?: '';
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
