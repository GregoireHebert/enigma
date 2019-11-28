<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Services\CartStateUpdateService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/carts/{id}/update-state", name="update_state")
 * @Security("is_granted('ROLE_MANAGER')")
 */
class UpdateCartStateController extends AbstractController
{
    /** @var CartStateUpdateService */
    private $cartStateUpdateService;

    public function __construct(CartStateUpdateService $cartStateUpdateService)
    {
        $this->cartStateUpdateService = $cartStateUpdateService;
    }

    public function __invoke(Cart $cart): Response
    {
        $this->cartStateUpdateService->updateStateForward($cart);

        $this->addFlash('success', sprintf(
            'State of cart number %d updated to %s',
            $cart->getId(),
            $cart->getState()->getLabel()
        ));

        return $this->redirect(
            $this->generateUrl('carts')
        );
    }
}
