<?php

declare(strict_types=1);

namespace App\Security;

use App\Security\Exception\AuthenticationException;
use App\Security\Exception\ForbiddenHttpException;

class Security
{
    public function removeUser(): void
    {
        unset($_SESSION['user']);
    }

    public function storeAuthenticatedUser(UserInterface $user): void
    {
        $_SESSION['user'] = $user;
    }

    public function getUser(): ?UserInterface
    {
        return $_SESSION['user'] ?? null;
    }

    public function hasRole(string $role): void
    {
        if (null === $user = $this->getUser()) {
            throw new AuthenticationException();
        }

        if (!in_array($role, $user->getRoles(), true)) {
            throw new ForbiddenHttpException();
        }
    }
}
