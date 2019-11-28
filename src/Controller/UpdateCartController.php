<?php


namespace App\Controller;


use App\Entity\Cart;
use App\Form\CreateCartType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * @Route(path="carts/{id}/update", methods={"GET","POST"}, name="carts_update")
 */
class UpdateCartController extends AbstractController
{

    public function __invoke(RouterInterface $router, Request $request, Cart $cart, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
    {
        // $this->denyAccessUnlessGranted(ProductResponsibilityVoter::VOTER_ATTRIBUTE, $product, 'Ce produit ne vous appartient pas.');

        $form = $formFactory->create(CreateCartType::class, $cart, array(
            'currentCart' => $cart
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return new RedirectResponse($router->generate('carts'));
        }

        return new Response($twig->render('updateCart.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart
        ]));
    }

}