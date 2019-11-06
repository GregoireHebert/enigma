<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Selection;
use App\Types\OrderType;
use App\Types\SelectionType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/orders/create", name="orders_create", methods={"GET"})
 */
class CreateOrderController
{
    public function __invoke(Environment $twig, FormFactoryInterface $formFactory): Response
    {
//        $order = new Order();
//        $form = $formFactory->create(OrderType::class, $order);

        $selection = new Selection();
        $form = $formFactory->create(SelectionType::class, $selection);

        return new Response($twig->render('orders/orderCreate.html.twig', [
            'form' => $form->createView()
        ]));
    }
}
