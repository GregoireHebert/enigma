<?php

declare(strict_types=1);

namespace App\EventSubscribers;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ProductEventsSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'alertManagers'
        ];
    }

    public function alertManagers(ResponseEvent $event): void
    {
        $request = $event->getRequest();

        if (
            'products_create' !== $request->attributes->get('_route') ||
            'POST' !== $request->getMethod()
        ) {
            return;
        }

        $this->logger->info('new product created', [
            'request' => $request
        ]);

    }
}
