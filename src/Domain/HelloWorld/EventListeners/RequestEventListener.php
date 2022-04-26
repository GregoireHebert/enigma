<?php

declare(strict_types=1);

namespace App\Domain\HelloWorld\EventListeners;

use App\Infra\EventDispatcher\Events\RequestEvent;
use App\Infra\Http\Response;

class RequestEventListener
{
    public function notify($event)
    {
        if (!$event instanceof RequestEvent) {
            return;
        }

        $request = $event->getRequest();
        $key = $request->getQuery('key');

        if ($key === null) {
            $event->setRequest(new Response('Key argument is missing'));
        }
    }
}
