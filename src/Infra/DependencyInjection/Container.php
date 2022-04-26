<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

class Container
{
    private array $services;

    public function __construct(...$services)
    {
        $this->services = $services;
    }

    public function get(string $name): mixed
    {
        foreach ($this->services as $key => $service)
        {
            if (is_object($service) && $service::class === $name) {
                return $service;
            }

            if (is_string($service) && $service === $name) {
                $this->services[$key] = new $service();
                return $this->services[$key];
            }
        }

        throw new \LogicException('service '.$name.' does not exists.');
    }
}
