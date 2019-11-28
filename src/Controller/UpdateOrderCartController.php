<?php
/**
 * Created by PhpStorm.
 * User: MUD0
 * Date: 28/11/2019
 * Time: 14:34
 */

namespace App\Controller;


use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class UpdateOrderCartController
 * @Route(methods={"GET", "POST"}, path="/carts/{id}/update", name="updateOrderStatus")
 */
class UpdateOrderCartController extends AbstractController
{
    public function __invoke(Request $request, Cart $cart, Environment $twig, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager): Response
    {
        return new Response($twig->render('updateOrderStatus.html.twig', [

        ]));
    }
}