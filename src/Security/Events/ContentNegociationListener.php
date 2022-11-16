<?php

declare(strict_types=1);

namespace App\Security\Events;

use App\Core\Events\RequestEvent;
use App\Core\Http\Exception\NotAcceptableHttpException;

class ContentNegociationListener
{
    private const TYPES = [
        'application/json'
    ];

    public function __invoke(RequestEvent $requestEvent)
    {
        $request = $requestEvent->getRequest();
        $headers = $request->getHeaders();
        $method = $request->getMethod();

        $contentType = $headers['content-type'] ?? '';
        if (in_array($method, ['POST', 'PUT', 'PATCH']) && !in_array($contentType, self::TYPES)) {
            throw new NotAcceptableHttpException(406, 'Content-Type header Not Acceptable.');
        }

        $accept = $headers['accept'] ?? '';
        if (in_array($method, ['GET', 'POST', 'PUT', 'PATCH']) && !in_array($accept, self::TYPES)) {
            throw new NotAcceptableHttpException(406, 'Accept header Not Acceptable.');
        }
    }
}
