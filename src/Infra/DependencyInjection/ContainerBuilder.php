<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

use App\Domain\Errors\Controller\Error404;
use App\Domain\HelloWorld\Controller\Bar;
use App\Domain\HelloWorld\Controller\World;
use App\Infra\Log\Logger;
use App\Infra\Routing\Router;

class ContainerBuilder
{
    /**
     * @var array<ServiceDefinition>
     */
    private array $definitions;

    private ArgumentsResolver $argumentsResolver;

    public function __construct(private array $servicesBooted = [])
    {
        $this->definitions[] = new ServiceDefinition(Logger::class);
        $this->definitions[] = new ServiceDefinition(Router::class);
        $this->definitions[] = new ServiceDefinition(Bar::class);
        $this->definitions[] = new ServiceDefinition(World::class);
        $this->definitions[] = new ServiceDefinition(Error404::class);

        $this->argumentsResolver = new ArgumentsResolver($this);
    }

    private function resolveArguments(ServiceDefinition $class): array
    {
        return $this->argumentsResolver->resolveArguments($class);
    }

    public function build(): Container
    {
        $services = $this->servicesBooted;



        foreach ($this->definitions as $definition)
        {
            $class = $definition->getClass();
            $arguments = $this->resolveArguments($definition);

            $services[] = new Service($class, $arguments);
        }

        return new Container(...$services);
    }
}
