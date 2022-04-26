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
        foreach ($this->services as $service)
        {
            if ($service::class === $name) {
                return $service;
            }
        }

        throw new \LogicException('service '.$name.' does not exists.');
    }
}
