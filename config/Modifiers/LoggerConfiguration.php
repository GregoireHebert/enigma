<?php

declare(strict_types=1);

return new class implements \App\Core\DependencyInjection\ConfigurationModifier
{
    public function modify(\App\Core\DependencyInjection\Container $container)
    {
        if (DEBUG === false) {
            $container->setServiceDefinition(
                \App\Core\Logger\LoggerInterface::class,
                new \App\Core\DependencyInjection\ServiceDefinition(\App\Core\Logger\DatedLogger::class)
            );
        }
    }
};
