<?php

namespace App\Customers\Application\Message;

use App\Customers\Infrastructure\Symfony\Model\User;
use App\Customers\Domain\Entity\User as DomainUser;
use Symfony\Component\Form\FormInterface;

final class UserRegistration
{
    public function __construct(public User|DomainUser $user, public readonly FormInterface $form)
    {
    }
}
