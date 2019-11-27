<?php

namespace App\Tests\EventSubscribers;

use App\EventSubscribers\ProductEventsSubscriber;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ProductEventsSubscriberTest extends TestCase
{

    public function testGetSubscribedEvents()
    {
        $expected = [
            KernelEvents::RESPONSE => 'alertManagers'
        ];

        $this->assertEquals($expected, ProductEventsSubscriber::getSubscribedEvents());
    }

    public function testAlertManagersWrongRoute()
    {
        $parameterBagMockProphecy = $this->prophesize(ParameterBag::class);
        $parameterBagMockProphecy->get('_route')->shouldBeCalled()->willReturn('bad_route');

        $requestMockProphecy = $this->prophesize(Request::class);
        $requestMockProphecy->getMethod()->shouldNotBeCalled();
        $requestMockProphecy->attributes = $parameterBagMockProphecy->reveal();

        $requestMock = $requestMockProphecy->reveal();

        $loggerMockProphecy = $this->prophesize(LoggerInterface::class);
        $loggerMockProphecy->info('new product created', [
            'request' => $requestMock
        ])->shouldNotBeCalled();

        $responseEventMockProphecy = $this->prophesize(ResponseEvent::class);
        $responseEventMockProphecy->getRequest()->shouldBeCalled()->willReturn($requestMock);

        $productEventsSubscriber = new ProductEventsSubscriber($loggerMockProphecy->reveal());
        $productEventsSubscriber->alertManagers($responseEventMockProphecy->reveal());
    }

    public function testAlertManagersWrongMethod()
    {
        $parameterBagMockProphecy = $this->prophesize(ParameterBag::class);
        $parameterBagMockProphecy->get('_route')->shouldBeCalled()->willReturn('products_create');

        $requestMockProphecy = $this->prophesize(Request::class);
        $requestMockProphecy->getMethod()->shouldBeCalled()->willReturn('GET');
        $requestMockProphecy->attributes = $parameterBagMockProphecy->reveal();

        $requestMock = $requestMockProphecy->reveal();

        $loggerMockProphecy = $this->prophesize(LoggerInterface::class);
        $loggerMockProphecy->info('new product created', [
            'request' => $requestMock
        ])->shouldNotBeCalled();

        $responseEventMockProphecy = $this->prophesize(ResponseEvent::class);
        $responseEventMockProphecy->getRequest()->shouldBeCalled()->willReturn($requestMock);

        $productEventsSubscriber = new ProductEventsSubscriber($loggerMockProphecy->reveal());
        $productEventsSubscriber->alertManagers($responseEventMockProphecy->reveal());
    }

    public function testAlertManagersLogger()
    {
        $parameterBagMockProphecy = $this->prophesize(ParameterBag::class);
        $parameterBagMockProphecy->get('_route')->shouldBeCalled()->willReturn('products_create');

        $requestMockProphecy = $this->prophesize(Request::class);
        $requestMockProphecy->getMethod()->shouldBeCalled()->willReturn('POST');
        $requestMockProphecy->attributes = $parameterBagMockProphecy->reveal();

        $requestMock = $requestMockProphecy->reveal();

        $loggerMockProphecy = $this->prophesize(LoggerInterface::class);
        $loggerMockProphecy->info('new product created', [
            'request' => $requestMock
        ])->shouldBeCalled();

        $responseEventMockProphecy = $this->prophesize(ResponseEvent::class);
        $responseEventMockProphecy->getRequest()->shouldBeCalled()->willReturn($requestMock);

        $productEventsSubscriber = new ProductEventsSubscriber($loggerMockProphecy->reveal());
        $productEventsSubscriber->alertManagers($responseEventMockProphecy->reveal());
    }
}
