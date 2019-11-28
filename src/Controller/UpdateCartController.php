<?php


namespace App\Controller;


use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * @Route(path="carts/{id}/update", methods={"GET", "POST"}, name="carts_update")
 */
class UpdateCartController extends AbstractController
{

    public function __invoke(RouterInterface $router, Request $request, Cart $cart, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
    {
        // $this->denyAccessUnlessGranted(ProductResponsibilityVoter::VOTER_ATTRIBUTE, $product, 'Ce produit ne vous appartient pas.');

        //$form = $formFactory->create(CreateProductType::class, $product);

        //$form->handleRequest($request);
        //if ($form->isSubmitted() && $form->isValid()) {
        //    $entityManager->flush();

        //    return new RedirectResponse($router->generate('products_list'));
        //}

        return new Response($twig->render('updateCart.html.twig', [
            'cart' => $cart
        ]));
    }

}