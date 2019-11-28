<?php

declare(strict_types=1);

namespace App\Voters;

use App\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProductResponsibilityVoter extends Voter
{
    public const VOTER_ATTRIBUTE = 'PRODUCT_RESPONSIBILITY';

    protected function supports($attribute, $subject): bool
    {
        return $attribute === self::VOTER_ATTRIBUTE && $subject instanceof Product;
    }

    /**
     * @param Product $subject
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        return $subject->getCategory()->getName() === 'Drinks' && stripos($token->getUsername(), 'g') === 0;
    }
}
