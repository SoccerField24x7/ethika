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
        $good = false;

        $arry = [
            'first_name' => 'Jesse',
            'last_name' => 'Quijano',
            'email' => 'jesse@quijano.net',
            'garbage' => 'as;dlfkjas' // this must be excluded from the test
        ];

        $ret = Order::toObject($arry);

        /* rather than doing this as part of the foreach, doing here so I can properly set $good - don't want to set it
            to true and have there be no columns in the table */
        $cols = $ret->getTableColumns();
        if (count($cols)) {
            $good = true; // so I can easily target false in the upcoming foreach
        }

        /* have to test object because array can contain elements not in the object */
        foreach ($ret as $key => $value) {
            if (!isset($arry[$key])) {
                continue;
            }

            if ($ret->{$key} != $arry[$key]) {
                $good = false;
            }
        }

        $this->assertTrue($good);
    }

    public function testOrderItemToModelCreatesValidOrderItemObject()
    {
        $good = false;

        $arry = [
            'order_id' => 1,
            'line_number' => 1,
            'name' => 'garlic toast',
            'quantity' => 123,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $ret = OrderItem::toObject($arry, new OrderItem());

        $cols = $ret->getTableColumns();
        if (count($cols)) {
            $good = true; // so I can easily target false in the upcoming foreach
        }

        /* have to test object because array can contain elements not in the object */
        foreach ($ret as $key => $value) {
            if (!isset($arry[$key])) {
                continue;
            }

            if ($ret->{$key} != $arry[$key]) {
                $good = false;
            }
        }

        $this->assertTrue($good);
    }

    public function testOrderWithLineItemsToObjectCreatesValidOrderAndOrderItemObjects()
    {
        $this->markTestSkipped('TDD: Coming soon');
    }
}
