<?php

declare(strict_types=1);

return new class implements \App\Core\DependencyInjection\ConfigurationModifier
{
    public function modify(\App\Core\DependencyInjection\Container $container)
    {
        if (DEBUG === true) {
            $loggerServiceDefinition = $container->getServiceDefinition(\App\Core\Logger\LoggerInterface::class);
            $loggerServiceDefinition->decorated = \App\Core\Logger\DatedLogger::class;
        }
    }
};
