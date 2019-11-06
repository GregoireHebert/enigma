<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Types\OrderType;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * @Route("/orders/create", name="orders_create", methods={"GET", "POST"})
 */
class CreateOrderController
{
    public function __invoke(
        Environment $twig,
        FormFactoryInterface $formFactory,
        Request $request,
        OrderRepository $orderRepository,
        RouterInterface $router
    ): Response
    {
        $order = new Order();
        $form = $formFactory->create(OrderType::class, $order);

        $form->handleRequest($request);
        try {
            if ($form->isValid()) {
                $order = $form->getData();
                $orderRepository->persistAndSave($order);

                return new RedirectResponse($router->generate('orders_list'));
            }
        } catch (LogicException $e) {
        }

        return new Response($twig->render('orders/orderCreate.html.twig', [
            'form' => $form->createView()
        ]));
    }
}
