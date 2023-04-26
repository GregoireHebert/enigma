<?php

namespace App\Message;

use App\Entity\User;
use Symfony\Component\Form\FormInterface;

final class UserRegistration
{
    public function __construct(public readonly User $user, public readonly FormInterface $form)
    {
    }
}
