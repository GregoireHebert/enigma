<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Order;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class MyOrderVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return $attribute === 'orderAccess' && $subject instanceof Order;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var Order $subject */
        return $subject->getName() === $token->getUsername() ||
            $this->security->isGranted('ROLE_ADMIN', $token->getUser());
    }
}
