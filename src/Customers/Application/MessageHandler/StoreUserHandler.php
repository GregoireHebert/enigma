<?php

declare(strict_types=1);

namespace App\Customers\Application\MessageHandler;

use App\Customers\Application\Message\UserRegistration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(priority: 32)]
class StoreUserHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(UserRegistration $userRegistration)
    {
        $this->entityManager->persist($userRegistration->user);
        $this->entityManager->flush();

    }
}
