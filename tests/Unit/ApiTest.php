<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use App\Models\Order;

class APITest extends TestCase
{
    // TODO:  Add PHPDoc comments

    private $headers = [
        'CONTENT_TYPE' => 'application/json',
        'HTTP_ACCEPT' => 'application/json',
        'Cache-control' => 'no-cache',
    ];

    public function testAddNewOrderSuccess()
    {

        $order = '{"first_name":"Test","last_name":"Order","email":"' . uniqid() . '@quijano.net","created_at":"' . gmdate('Y-m-d H:i:s') .'","updated_at":null,"order_items":[{"order_id":1,"line_number":1,"name":"undies","quantity":3,"created_at":"2019-04-06 23:08:33","updated_at":null}]}';

        $response = $this->call('post',
            '/api/1.0/order-save', // action (defined in routes.php)
            [],
            [],
            [],
            $this->headers,
            $order
        );

        $result = json_decode($response->getContent());

        $this->assertTrue(isset($result->Success) ? true : false);
    }

    public function testAddNewOrderFailsValidationNoLastName()
    {
        $order = '{"first_name":"Test","email":"' . uniqid() . '@quijano.net","created_at":"2019-04-06 23:04:00","updated_at":null,"order_items":[{"order_id":1,"line_number":1,"name":"undies","quantity":3,"created_at":"2019-04-06 23:08:33","updated_at":null}]}';
        $response = $this->call('post',
            '/api/1.0/order-save', // action (defined in routes.php)
            [],
            [],
            [],
            $this->headers,
            $order
        );

        $result = json_decode($response->getContent());

        $this->assertTrue(isset($result->Error) ? true : false);
    }

    public function testAddNewOrderFailsValidationDuplicateEmailAddress()
    {
        $order = Order::first();

        $order = '{"first_name":"Test","last_name":"Failed","email":"' . $order->email . '","created_at":"2019-04-06 23:04:00","updated_at":null,"order_items":[{"order_id":1,"line_number":1,"name":"undies","quantity":3,"created_at":"2019-04-06 23:08:33","updated_at":null}]}';
        $response = $this->call('post',
            '/api/1.0/order-save', // action (defined in routes.php)
            [],
            [],
            [],
            $this->headers,
            $order
        );

        $result = json_decode($response->getContent());

        $this->assertTrue($result->Error == "Validation failed:The email has already been taken.");
    }

    public function testGetOrderByIdSuccess()
    {
        /* find an existing order to ensure we have a valid key */
        $order = Order::orderBy('id', 'DESC')->first();

        $response = $this->call('get',
            '/api/1.0/order/' . $order->id,
            [],
            [],
            [],
            $this->headers
        );

        $result = json_decode($response->getContent());

        $this->assertTrue(isset($result->Success) ? true : false);
    }

    public function testOrderSaveFailsWithFKViolation()
    {
        $order = '{"first_name":"Test","last_name":"Order","email":"' . uniqid() . '@quijano.net","created_at":"' . gmdate('Y-m-d H:i:s') .'","updated_at":null,"order_items":[{"order_id":1,"line_number":1,"name":"undies","quantity":3,"created_at":"2019-04-06 23:08:33","updated_at":null},{"order_id":1,"line_number":1,"name":"hoodie","quantity":1,"created_at":"2019-04-08 23:08:33","updated_at":null}]}';
        $response = $this->call('post',
            '/api/1.0/order-save', // action (defined in routes.php)
            [],
            [],
            [],
            $this->headers,
            $order
        );

        $result = json_decode($response->getContent());

        $this->assertNotFalse(strpos($result->Error, 'Unique violation'));
    }

    public function testGetOrderByIdInvalidOrderId()
    {
        $this->markTestSkipped();
    }

    public function testPutOrder()
    {
        $order = '{"id":1,"first_name":"Test","last_name":"Order","email":"1@quijano.net","created_at":"2019-04-06 23:04:00","updated_at":null,"order_items":[{"order_id":1,"line_number":1,"name":"undies","quantity":3,"created_at":"2019-04-06 23:08:33","updated_at":null}]}';
        $this->markTestSkipped();
    }

    public function testPutOrderIsIdempotent()
    {
        $this->markTestSkipped();
    }

    public function testPatchOrderSuccess()
    {
        $this->markTestSkipped();
    }

}
