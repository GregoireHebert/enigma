<?php

namespace App\Message;

use App\Entity\User;

final class UserRegistration
{
    public function __construct(public readonly User $user)
    {
    }
}
