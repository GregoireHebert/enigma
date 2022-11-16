<?php

declare(strict_types=1);

namespace App\Core\Api\Events;

use App\Core\Events\RespondEvent;

class StatusHttpListener
{
    public function __invoke(RespondEvent $respondEvent)
    {
        $request = $respondEvent->getRequest();
        $method = $request->getMethod();

        $statusCode = match ($method) {
            'GET', 'PUT', 'PATCH' => 200,
            'DELETE' => 204,
            'POST' => 201,
        };

        http_response_code($statusCode);
    }
}
