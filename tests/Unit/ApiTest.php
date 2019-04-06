<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;

class APITest extends TestCase
{
    // TODO:  Add PHPDoc comments

    public function testAddNewOrderSuccess()
    {
        $this->markTestSkipped();
    }

    public function testAddNewOrderFailsValidation()
    {
        $this->markTestSkipped();
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
