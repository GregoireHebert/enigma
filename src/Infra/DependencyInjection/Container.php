<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

class Container
{
    private array $services;
    private ArgumentsResolver $argumentsResolver;

    public function __construct(...$services)
    {
        $this->services = $services;
        $this->argumentsResolver = new ArgumentsResolver($this);
    }

    public function resolveArguments($class, string $method): array
    {
        return $this->argumentsResolver->resolveArguments($class, $method);
    }

    public function get(string $name): mixed
    {
        foreach ($this->services as $key => $service)
        {
            if (is_object($service) && $service::class === $name) {
                return $service;
            }

            if (is_string($service) && $service === $name) {
                $arguments = $this->resolveArguments($service, '__construct');
                $this->services[$key] = new $service(...$arguments);
                return $this->services[$key];
            }
        }

        throw new \LogicException('service '.$name.' does not exists.');
    }
}
