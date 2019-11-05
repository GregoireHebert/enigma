<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class OrderDetail
{
    public function __invoke(Environment $twig)
    {
        $order = [
            'number' => 2,
            'products' => [
                ['name' => 'Burger', 'price' => 4, 'quantity' => 1],
                ['name' => 'Frite', 'price' => 1, 'quantity' => 1],
                ['name' => 'Coca', 'price' => 2, 'quantity' => 1],
            ],
            'status' => 'En préparation',
            'amount' => 7
        ];

        return new Response(
            $twig->render('orders/orderDetail.html.twig',
                [
                    'order' => $order
                ]
            )
        );
    }
}
