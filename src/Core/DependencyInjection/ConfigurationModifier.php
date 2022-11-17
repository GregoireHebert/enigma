<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection;

interface ConfigurationModifier
{
    public function modify(Container $container);
}
