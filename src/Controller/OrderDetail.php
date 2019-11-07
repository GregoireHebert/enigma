<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Twig\Environment;

class OrderDetail
{
    public function __invoke(Environment $twig, Order $order, AuthorizationCheckerInterface $authorizationChecker)
    {
        if (!$authorizationChecker->isGranted('orderAccess', $order)) {
            throw new AccessDeniedHttpException();
        }

        return new Response(
            $twig->render('orders/orderDetail.html.twig',
                [
                    'order' => $order
                ]
            )
        );
    }
}
