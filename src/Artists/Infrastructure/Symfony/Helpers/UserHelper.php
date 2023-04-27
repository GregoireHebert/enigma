<?php

declare(strict_types=1);

namespace App\Artists\Infrastructure\Symfony\Helpers;

use App\Customers\Domain\Entity\User;

trait UserHelper
{
    private function getDomainUser(): User
    {
        if (($user = $this->getUser()) && $user instanceof User) {
            return $user;
        }

        throw new \LogicException('User should be of type `'.User::class.'` got `'.gettype($user).'`');
    }
}
