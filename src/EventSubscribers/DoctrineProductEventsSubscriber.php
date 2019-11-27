<?php

declare(strict_types=1);

namespace App\EventSubscribers;

use App\Entity\Product;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;

class DoctrineProductEventsSubscriber implements EventSubscriber
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $object = $args->getObject();

        if (!$object instanceof Product) {
            return;
        }

        $this->logger->info('Product created (doctrine events)',[
            'product' => $object
        ]);
    }
}
