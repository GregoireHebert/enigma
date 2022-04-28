<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

class Container
{
    /**
     * @var Service[]
     */
    private array $services;

    public function __construct(Service ...$services)
    {
        $this->services = $services;
    }

    public function addService($id, $service): void
    {
        $this->services[$id] = $service;
    }

    public function resolveArguments(Reference ...$argumentsReferences)
    {
        $arguments = [];

        foreach ($argumentsReferences as $argument) {
            $arguments[] = $this->get($argument->id);
        }

        return $arguments;
    }

    public function get(string $name): mixed
    {
        foreach ($this->services as $key => $service)
        {
            if (!$this->services[$key] instanceof Service) {
                return $this->services[$key];
            }

            if ($service->class === $name) {
                $arguments = $this->resolveArguments(...$service->arguments);
                $this->services[$key] = new $service->class(...$arguments);
                return $this->services[$key];
            }
        }

        throw new \LogicException('service '.$name.' does not exists.');
    }
}
