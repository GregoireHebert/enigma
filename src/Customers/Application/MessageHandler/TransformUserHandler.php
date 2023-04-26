<?php

declare(strict_types=1);

namespace App\Customers\Application\MessageHandler;

use App\Customers\Application\Message\UserRegistration;
use App\Customers\Domain\Entity\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(priority: 256)]
class TransformUserHandler
{
    public function __invoke(UserRegistration $userRegistration)
    {
        $user = new User();
        $user->setEmail($userRegistration->user->email);
        $user->setDisplayName($userRegistration->user->displayName);

        $userRegistration->user = $user;
    }
}
