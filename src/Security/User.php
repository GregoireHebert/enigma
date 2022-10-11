<?php

declare(strict_types=1);

namespace App\Security;

final class User
{
    public function __construct(
        private readonly string $id,
        private readonly string $email,
        private readonly string $username,
        private string $password,
        private readonly array $roles)
    {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
