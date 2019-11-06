<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class OrderDetail
{
    public function __invoke(Environment $twig, Order $order)
    {
        return new Response(
            $twig->render('orders/orderDetail.html.twig',
                [
                    'order' => $order
                ]
            )
        );
    }
}
