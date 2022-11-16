<?php

declare(strict_types=1);

namespace App\Core\Events;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

class EventDispatcher implements ListenerProviderInterface, EventDispatcherInterface
{
    private array $listeners = [];

    public function dispatch(object $event): object
    {
        foreach ($this->getListenersForEvent($event) as $listener) {
            $listener($event);

            if ($listener instanceof StoppableEventInterface && $listener->isPropagationStopped()) {
                return $event;
            }
        }

        return $event;
    }

    public function getListenersForEvent(object $event): iterable
    {
        return $this->listeners[$event::class] ?? [];
    }

    public function addListener(object $listener, string $event): void
    {
        if (!class_exists($event)) {
            throw new \LogicException("Event $event does not exists.");
        }

        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = new \SplObjectStorage();
        }

        $this->listeners[$event]->attach($listener);
    }
}
