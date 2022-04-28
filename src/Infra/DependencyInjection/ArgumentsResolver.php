<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

class ArgumentsResolver
{
    public function __construct(private ContainerBuilder $containerBuilder)
    {
    }

    public function resolveArguments(ServiceDefinition $definition): array
    {
        $arguments = [];

        $class = $definition->getClass();
        $method = $definition->getMethod();

        if (!method_exists($class, $method)) {
            return $arguments;
        }

        $methodReflection = new \ReflectionMethod($class, $method);

        foreach ($methodReflection->getParameters() as $reflectionParameter)
        {
            $serviceType = $reflectionParameter->getType();
            $arguments[] = new Reference($serviceType->getName());
        }

        return $arguments;
    }
}
