<?php

declare(strict_types=1);

namespace App\Test\Entity;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\Selection;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testDefaultTotal()
    {
        $cart = new Cart();
        $this->assertEquals(0, $cart->getTotal());
    }

    public function testTotalUpdatedWithSelections()
    {
        $cart = new Cart();

        $productMockProphecy = $this->prophesize(Product::class);
        $productMockProphecy->getPrice()->shouldBeCalled()->willReturn(200);

        $selectionMockProphecy = $this->prophesize(Selection::class);
        $selectionMockProphecy->getQuantity()->shouldBeCalled()->willReturn(2);
        $selectionMockProphecy->getProduct()->shouldBeCalled()->willReturn($productMockProphecy->reveal());

        $cart->addSelection($selectionMockProphecy->reveal());

        $this->assertEquals(400, $cart->getTotal());

        $cart->removeSelection($selectionMockProphecy->reveal());

        $this->assertEquals(0, $cart->getTotal());
    }
}
