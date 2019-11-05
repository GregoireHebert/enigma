<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class OrderDetail
{
    public function __invoke(Environment $twig)
    {
        return new Response(
            $twig->render('orders/orderDetail.html.twig')
        );
    }
}
