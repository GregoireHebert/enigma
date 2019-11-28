<?php


namespace App\Controller;


use App\Entity\Cart;
use App\Form\CreateCartType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * Class UpdateCartStatus
 * @package App\Controller
 *
 * @Route(path="carts/{id}/update_status", methods={"GET", "POST"}, name="cart_status_update")
 * @Security("is_granted('ROLE_MANAGER')")
 */
class UpdateCartStatus extends AbstractController
{
    public function __invoke(RouterInterface $router, Request $request, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, Cart $cart)
    {
        $form = $formFactory->create(CreateCartType::class, $cart);

        $oldCartStatus = $cart->getStatus();
        $oldCartLevel = $oldCartStatus->getLevel();
        $currentStatus = $oldCartStatus->getName();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newCartLevel = $cart->getStatus()->getLevel();
            if ($newCartLevel >= $oldCartLevel && abs($oldCartLevel - $newCartLevel) <= 1) {
                $entityManager->flush();
                return new RedirectResponse($router->generate('carts'));
            }
            else {
                $form->get('status')->addError(new FormError('Incorrect workflow'));
            }

        }

        return new Response(
            $twig->render(
                'updateCartStatus.html.twig',
                [
                    'status' => $currentStatus,
                    'cart' => $cart,
                    'form' => $form->createView()
                ]
            )
        );
    }
}