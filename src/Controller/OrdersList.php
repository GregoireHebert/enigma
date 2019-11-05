<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class OrdersList
{
    public function __invoke(Environment $twig)
    {
        $list = [
          ['number'=>1, 'amount'=>18, 'status'=>'En préparation'],
          ['number'=>2, 'amount'=>3, 'status'=>'Prêt'],
          ['number'=>3, 'amount'=>39, 'status'=>'Emporté'],
        ];

        return new Response(
            $twig->render('orders/ordersList.html.twig',
                [
                    'orders' => $list
                ]
            )
        );
    }
}
