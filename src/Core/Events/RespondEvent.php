<?php

declare(strict_types=1);

namespace App\Core\Events;

use App\Core\Http\Request;

final class RespondEvent
{
    public function __construct(
        private $controllerResult,
        private readonly Request $request
    ) {
    }

    public function getControllerResult()
    {
        return $this->controllerResult;
    }

    public function setControllerResult($controllerResult): void
    {
        $this->controllerResult = $controllerResult;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
