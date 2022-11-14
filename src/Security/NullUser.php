<?php

declare(strict_types=1);

namespace App\Security;

final class NullUser implements UserInterface
{
    public function getId(): string
    {
        return 'null';
    }

    public function getEmail(): string
    {
        return 'null@null.null';
    }

    public function getUsername(): string
    {
        return 'null name';
    }

    public function getPassword(): string
    {
        return 'null password';
    }

    public function setPassword(string $password): void
    {
    }

    public function getRoles(): array
    {
        return ['ROLE_NULL'];
    }
}
