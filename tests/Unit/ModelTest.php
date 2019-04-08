<?php
namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use Tests\TestCase;


class ModelTest extends TestCase
{
    public function testCreateOrder()
    {
        $good = false;

        $random = uniqid();

        $order = new Order();
        $order->first_name = 'Jesse';
        $order->last_name = 'Quijano';
        $order->email = $random . '@quijano.net'; // ensure the email address is random
        $order->created_at = gmdate('Y-m-d H:i:s');

        if ($order->save()) {
            $good = true;
        }

        $this->assertTrue($good);
    }

    public function testValidatorSuccess()
    {
        $this->markTestSkipped('TDD: Coming soon');
    }

    public function testOrderToModelCreatesValidOrderObject()
    {
        $this->markTestSkipped('TDD: Coming soon');
    }

    public function testOrderItemToModelCreatesValidOrderItemObject()
    {
        $this->markTestSkipped('TDD: Coming soon');
    }

    public function testOrderWithLineItemsToObjectCreatesValidOrderAndOrderItemObjects()
    {
        $this->markTestSkipped('TDD: Coming soon');
    }
}
