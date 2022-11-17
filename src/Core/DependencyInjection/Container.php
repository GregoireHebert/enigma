<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection;

class Container
{
    /** @var array<string, ServiceDefinition>  */
    private array $servicesDefinitions = [];

    private array $servicesInstances = [];

    /**
     * @param array<string, ServiceDefinition> $servicesDefinitions with the serviceName as Key.
     */
    public function __construct(array $servicesDefinitions = [])
    {
        foreach ($servicesDefinitions as $serviceName => $service) {
            $this->servicesDefinitions[$serviceName] = $service;
        }
    }

    private function locate(string $serviceName): ServiceDefinition
    {
        if (!isset($this->servicesDefinitions[$serviceName])) {
            throw new \LogicException("Service $serviceName does not exists. Did you forget to import it?");
        }

        return $this->servicesDefinitions[$serviceName];
    }

    public function getService(string $serviceName)
    {
        if (!isset($this->servicesInstances[$serviceName])) {
            $service = $this->locate($serviceName);
            $this->servicesInstances[$serviceName] = new $service->className(...$service->arguments);
        }

        return $this->servicesInstances[$serviceName];
    }
}
