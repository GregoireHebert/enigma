<?php

declare(strict_types=1);

namespace App\Domain\HelloWorld\Controller;

use App\Infra\Http\Response;
use App\Infra\Log\Logger;

class Bar
{
    public function __invoke(Logger $logger): Response
    {
        $logger->log('['.time().'] bar');
        return new Response('bar');
    }
}
