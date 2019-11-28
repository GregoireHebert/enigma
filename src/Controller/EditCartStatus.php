<?php
/**
 * Created by PhpStorm.
 * User: fouissi
 * Date: 2019-11-28
 * Time: 14:09
 */

namespace App\Controller;


use App\Entity\Cart;
use App\Repository\CartRepository;
use App\Voters\CartResponsibilityVoter;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * @Route(path="carts/{id}/update", methods={"GET", "POST"}, name="carts_update")
 */
class EditCartStatus
{
  public function __invoke(RouterInterface $router, Cart $cart, CartRepository $cartRepository, FormFactoryInterface $formFactory)
  {
    //$cart->setStatus();

    $this->denyAccessUnlessGranted(CartResponsibilityVoter::VOTER_ATTRIBUTE, $cart, 'Vous ne pouvez pas modifier cette commande');

    //$form = $formFactory->create()
  }
}