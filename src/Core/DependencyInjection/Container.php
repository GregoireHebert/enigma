<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection;

class Container
{
    /** @var array<string, ServiceDefinition>  */
    private array $servicesDefinitions = [];

    private array $servicesInstances = [];

    public bool $isBooted = false;

    /**
     * @param array<string, ServiceDefinition> $servicesDefinitions with the serviceName as Key.
     */
    public function __construct(array $servicesDefinitions = [])
    {
        foreach ($servicesDefinitions as $serviceName => $service) {
            $this->servicesDefinitions[$serviceName] = $service;
        }
    }

    public function getServiceDefinition(string $serviceName): ServiceDefinition
    {
        return $this->locate($serviceName);
    }

    public function setServiceDefinition(string $serviceName, ServiceDefinition $serviceDefinition)
    {
        if ($this->isBooted) {
            throw new \LogicException('Container already booted, you cannot change a service');
        }

        $this->servicesDefinitions[$serviceName] = $serviceDefinition;
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

            if (null !== $decorator = $service->decorated) {
                $this->servicesInstances[$serviceName. '.decorated'] = new $service->className($this, ...$service->arguments);
                $this->servicesInstances[$serviceName] = new $decorator($this->servicesInstances[$serviceName. '.decorated']);
            } else {
                $this->servicesInstances[$serviceName] = new $service->className($this, ...$service->arguments);
            }
        }

        return $this->servicesInstances[$serviceName];
    }
}
