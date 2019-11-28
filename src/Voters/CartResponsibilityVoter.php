<?php
/**
 * Created by PhpStorm.
 * User: fouissi
 * Date: 2019-11-28
 * Time: 14:32
 */

namespace App\Voters;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CartResponsibilityVoter extends Voter
{
  public const VOTER_ATTRIBUTE = 'CART_RESPONSIBILITY';

  protected function supports($attribute, $subject): bool
  {
    return $attribute === self::VOTER_ATTRIBUTE && $subject instanceof Cart;
  }

  protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
  {
    // TODO: Implement voteOnAttribute() method.
  }
}