<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\User;

class FirstLetterIsAVoter extends Voter
{
    protected function supports($attribute, $subject): bool
    {
        return $attribute === 'firstLetter' && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return false !== stripos($token->getUser()->getUsername(), 'a');
    }
}
