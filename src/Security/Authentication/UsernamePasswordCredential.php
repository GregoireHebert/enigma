<?php

declare(strict_types=1);

namespace App\Security\Authentication;

final class UsernamePasswordCredential
{
    public function __construct(public readonly string $username, public readonly string $password)
    {
    }
}
