<?php

namespace App\Customers\Infrastructure\Symfony\Model;

class User
{
    public function __construct(
        public readonly string $email,
        public readonly string $displayName
    ) {}
}
