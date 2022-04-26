<?php

declare(strict_types=1);

namespace App\Domain\HelloWorld\Controller;

use App\Infra\DependencyInjection\Container;
use App\Infra\Http\Response;
use App\Infra\Log\Logger;

class Bar
{
    public function __invoke(Container $container): Response
    {
        $logger = $container->get(Logger::class);
        $logger->log('['.time().'] bar');
        return new Response('bar');
    }
}
