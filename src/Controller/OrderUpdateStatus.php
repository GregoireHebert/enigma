<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderUpdateStatus
{
    public function __invoke(
        Order $order,
        $status,
        OrderRepository $orderRepository,
        RouterInterface $router,
        ValidatorInterface $validator,
        Session $session
    ) {
        $order->setStatus($status);

        $constraintViolationList = $validator->validate($order);
        $flashbag = $session->getFlashBag();

        if (!$constraintViolationList->count()) {
            // add flash bag succès
            $flashbag->add('success', 'Status mis à jour avec succès.');
            $orderRepository->save($order);

            return new RedirectResponse(
                $router->generate('orders_detail', ['id'=> $order->getNumber()])
            );
        }

        /** @var ConstraintViolation $violation */
        foreach ($constraintViolationList as $violation) {
            $flashbag->add('error', $violation->getPropertyPath().': '.$violation->getMessage());
        }

        return new RedirectResponse(
            $router->generate('orders_detail', ['id'=> $order->getNumber()])
        );
    }
}
