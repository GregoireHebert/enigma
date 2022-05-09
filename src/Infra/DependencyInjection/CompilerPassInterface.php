<?php

declare(strict_types=1);

namespace App\Infra\DependencyInjection;

interface CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
    }
}
