<?php

declare(strict_types=1);

namespace App\Core\Events;

use App\Core\Http\Request;

final class RequestEvent
{
    public function __construct(
        private Request $request
    ) {
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
