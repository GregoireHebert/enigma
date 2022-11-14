<?php

declare(strict_types=1);

namespace App\Security;

interface UserInterface
{
    public function getId(): string;

    public function getEmail(): string;

    public function getUsername(): string;

    public function getPassword(): string;

    public function setPassword(string $password): void;

    /**
     * @return array<string>
     */
    public function getRoles(): array;
}
