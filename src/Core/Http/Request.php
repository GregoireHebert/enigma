<?php

declare(strict_types=1);

namespace App\Core\Http;

use App\Core\Http\Exception\UnprocessableEntityHttpException;

final class Request
{
    /** @var array<string, mixed> */
    private array $attributes = [];

    private function __construct(
        /** @var array<string, mixed> */
        private array $post,
        private string $path,
        private string $method,
        /** @var array<string, string> */
        private array $headers = [],
    ) {
        if (($this->headers['content-type'] ?? '') === 'application/json') {
            try {
                $this->post = json_decode($this->getContent(), true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                throw new UnprocessableEntityHttpException();
            }
        }
    }

    public static function createFromGlobals(): self
    {
        return new self(
            $_POST,
            $_SERVER['PATH_INFO'] ?? '/',
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            self::extractHeaders($_SERVER)
        );
    }

    /**
     * @param array<string, string> $server
     * @return array<string, string>
     */
    private static function extractHeaders(array $server): array
    {
        $headers = [];

        foreach ($server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                // TODO split $value by coma and extract header options
                $headers[str_replace('_', '-', strtolower(substr($key, 5)))] = $value;
            }
        }

        return $headers;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setAttribute(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function getAttribute(string $name, mixed $default = null): mixed
    {
        return $this->attributes[$name] ?? $default;
    }

    public function getRequest(string $name, mixed $default = null): mixed
    {
        return $this->post[$name] ?? $default;
    }

    /**
     * @return array<string, string|number>
     */
    public function getRequests(): array
    {
        return $this->post;
    }

    public function getContent(): string
    {
        if (false === $resource = fopen('php://input', 'rb')) {
            return '';
        }

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
