<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Controller\OrderDetail;
use App\Entity\Order;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class OrderDetailTest extends TestCase
{
    public function testInvoke(): void
    {
        $orderDetail = new OrderDetail();
        $orderProphecy = $this->prophesize(Order::class);
        $twigProphecy = $this->prophesize(Environment::class);

        $orderReveal = $orderProphecy->reveal();
        $twigProphecy->render('orders/orderDetail.html.twig', ['order'=> $orderReveal])->shouldBeCalled();

        $response = $orderDetail($twigProphecy->reveal(), $orderReveal);
        $this->assertInstanceOf(Response::class, $response);
    }
}
