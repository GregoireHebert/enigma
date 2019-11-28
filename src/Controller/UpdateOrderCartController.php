<?php
/**
 * Created by PhpStorm.
 * User: MUD0
 * Date: 28/11/2019
 * Time: 14:34
 */

namespace App\Controller;


use App\Entity\Cart;
use App\Form\UpdateOrderStatusType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * Class UpdateOrderCartController
 * @Route(methods={"GET", "POST"}, path="/carts/{id}/update", name="updateOrderStatus")
 */
class UpdateOrderCartController extends AbstractController
{
    public function __invoke(RouterInterface $router, Request $request, Cart $cart, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager): Response
    {
        $form = $formFactory->create(UpdateOrderStatusType::class);

        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $entityManager->flush();

            return $this->redirect($router->generate('carts'));
        }

        return new Response($twig->render('updateOrderStatus.html.twig', [
            'form' => $form->createView()
        ]));
    }
}