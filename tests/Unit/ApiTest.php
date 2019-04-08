<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;

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

    public function testGetOrderByIdSuccess()
    {
        $this->markTestSkipped();
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
