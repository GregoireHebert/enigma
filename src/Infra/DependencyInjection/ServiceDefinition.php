<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

class ServiceDefinition
{
    private string $id;
    private string $class;
    private array $arguments;
    private string $method;

    public function __construct(string $class, ?string $id = null, string $method = '__construct')
    {
        $this->class = $class;
        $this->id = $id ?? $class;
        $this->method = $method;
    }

    public function setArguments(Reference ...$references)
    {
        $this->arguments = $references;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
