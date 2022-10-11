<?php

declare(strict_types=1);

namespace App\Security;

class Security
{
    public function removeUser(): void
    {
        unset($_SESSION['user']);
    }

    public function storeAuthenticatedUser(User $user): void
    {
        $_SESSION['user'] = $user;
    }

    public function getUser(): ?User
    {
        return $_SESSION['user'] ?? null;
    }
}
