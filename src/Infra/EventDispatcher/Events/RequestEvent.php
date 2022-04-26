<?php

declare(strict_types=1);

namespace App\Infra\EventDispatcher\Events;

use App\Infra\Http\Request;

class RequestEvent
{
    public function __construct(private $request)
    {
    }

    /**
     * @return Request|mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest($request): void
    {
        $this->request = $request;
    }
}
