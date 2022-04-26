<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

class ArgumentsResolver
{
    public function __construct(private Container $container)
    {
    }

    public function resolveArguments($class, string $method): array
    {
        $arguments = [];

        if (!method_exists($class, $method)) {
            return $arguments;
        }

        $methodReflection = new \ReflectionMethod($class, $method);

        foreach ($methodReflection->getParameters() as $reflectionParameter)
        {
            $serviceType = $reflectionParameter->getType();
            $arguments[] = $this->container->get($serviceType->getName());
        }

        return $arguments;
    }
}
