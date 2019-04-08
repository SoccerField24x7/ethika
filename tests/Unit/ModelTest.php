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
        $arry = [
            'first_name' => 'Jesse',
            'last_name' => 'Quijano',
            'email' => 'jesse@quijano.net',
            'garbage' => 'as;dlfkjas' // this must be excluded from the test
        ];

        $ret = Order::toObject($arry);

        $this->assertTrue($this->isObjectSameAsArray($ret, $arry));
    }

    public function testOrderItemToModelCreatesValidOrderItemObject()
    {
        $arry = [
            'order_id' => 1,
            'line_number' => 1,
            'name' => 'garlic toast',
            'quantity' => 123,
            'created_at' => date('Y-m-d H:i:s'),
            'garbage' => 'adsdadfs'
        ];

        $ret = OrderItem::toObject($arry, new OrderItem());

        $this->assertTrue($this->isObjectSameAsArray($ret, $arry));
    }

    public function testOrderWithLineItemsToObjectCreatesValidOrderAndOrderItemObjects()
    {
        $arry = [
            'first_name' => 'Jesse',
            'last_name' => 'Quijano',
            'email' => 'jesse@quijano.net',
            'garbage' => 'as;dlfkjas',
            'order_items' => [
                [
                    'order_id' => 1,
                    'line_number' => 1,
                    'name' => 'garlic toast',
                    'quantity' => 123,
                    'created_at' => date('Y-m-d H:i:s'),
                    'garbage' => 'adsdadfs'
                ]
            ]
        ];

        $ret = Order::toObject($arry);

        //$ret->order_items[0]->order_id=6;

        $good = $this->isObjectSameAsArray($ret, $arry);

        /* ensure each order line was converted properly */
        $i = 0;
        foreach ($ret->order_items as $line) {
            if (!$good = $this->isObjectSameAsArray($line, $arry['order_items'][$i++])) {
                break;
            }
        }

        $this->assertTrue($good);
    }

    public function testOrderWithLineItemsToObjectFailsOnBadOrderItem()
    {
        $arry = [
            'first_name' => 'Jesse',
            'last_name' => 'Quijano',
            'email' => 'jesse@quijano.net',
            'garbage' => 'as;dlfkjas',
            'order_items' => [
                [
                    'order_id' => 1,
                    'line_number' => 1,
                    'name' => 'garlic toast',
                    'quantity' => 123,
                    'created_at' => date('Y-m-d H:i:s'),
                    'garbage' => 'adsdadfs'
                ]
            ]
        ];

        $ret = Order::toObject($arry);

        $ret->order_items[0]->order_id=6;

        $good = $this->isObjectSameAsArray($ret, $arry);

        /* ensure each order line was converted properly */
        $i = 0;
        foreach ($ret->order_items as $line) {
            if (!$good = $this->isObjectSameAsArray($line, $arry['order_items'][$i++])) {
                break;
            }
        }

        $this->assertFalse($good);
    }

    private function isObjectSameAsArray($obj, $arry) : bool
    {
        $same = false;

        $cols = $obj->getTableColumns();

        if (count($cols)) {
            $same = true; // so I can easily target false in the upcoming foreach
        }

        /* have to test object because array can contain elements not in the object */
        foreach ($cols as $col) {
            if (!isset($arry[$col])) {
                continue;
            }

            if ($obj->{$col} != $arry[$col]) {
                $same = false;
            }
        }

        return $same;
    }
}
