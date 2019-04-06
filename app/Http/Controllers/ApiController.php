<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use mysql_xdevapi\Exception;

class ApiController extends BaseController
{
    public function saveOrder(string $orderData) : string
    {

        // attempt to convert to object, then validate
        try {
            $order = json_decode($orderData);
            if (!$this->validateOrder($order)) {
                throw new \Exception('Order failed validation.');  //determine how you want to bubble up error, and add to output
            }
        } catch (\Exception $ex)
        {
            // log

            // output error

            exit();
        }

        if (!empty($order->Id))
        {
            return $this->updateOrder();
        }

        return '';  // create standardized response object, then return
    }

    public function updateOrder() : string
    {
        // persist

        // expire cache/re-cache

        return '';  // create standardized response object, then return
    }

    public function getOrder(int $orderId) : string
    {
        // check cache and return

        //
    }

    public function deleteOrder(int $orderId) : string
    {
        // remove from db

        // expire from cache

        return ''; // create standardized response object, then return
    }

    private function validateOrder($order) : bool
    {
        $valid = false;

        return $valid;
    }
}
