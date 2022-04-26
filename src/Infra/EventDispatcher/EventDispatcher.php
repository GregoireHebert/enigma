<?php

declare(strict_types=1);

namespace App\Infra\EventDispatcher;

class EventDispatcher
{
    private array $eventListeners = [];

    public function addListener($listener)
    {
        $this->eventListeners[] = $listener;
    }

    public function dispatch($event)
    {
        foreach ($this->eventListeners as $eventListener) {
            $eventListener->notify($event);
        }
    }
}
