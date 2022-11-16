<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Serializer\Annotation\Ignore;

final class User implements UserInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $email,
        private readonly string $username,
        private string $password,
        /** @var array<string> */
        private readonly array $roles
    ) {
    }

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

    #[Ignore]
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return ['ROLE_ADMIN', ...$this->roles];
    }
}
