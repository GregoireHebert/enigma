<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class OrderUpdateStatus
{
    public function __invoke(
        Order $order,
        $status,
        OrderRepository $orderRepository,
        RouterInterface $router
    ) {
        $order->setStatus($status);

        $orderRepository->save($order);

        return new RedirectResponse(
            $router->generate('orders_detail', ['id'=> $order->getNumber()])
        );
    }
}
