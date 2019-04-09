<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ApiController extends BaseController
{
    /**
     * POST endpoint to save an order. It expects to receive a JSON order object, and returns JSON with status of
     * request and order object on Success.
     * @param Request $request
     * @return string
     */
    public function saveOrder(Request $request) : string
    {
        $orderData = $request->input();

        if (empty($orderData) || !is_array($orderData)) {
            return json_encode(['Error' => 'Invalid Order data.']);
        }

        /* attempt to convert to object, then validate */
        try {
            $order = Order::toObject($orderData);
            if (!$order->validate($orderData)) {
                throw new \Exception("Validation failed:" . $order->errors()[0]);  //pick first error (TODO: expand to include ALL)
            }
        } catch (\Exception $ex)
        {
            // log

            // output error
            return json_encode(['Error' => $ex->getMessage()]);
        }

        /* in case they are trying to update via POST, send them to updateOrder() */
        if (!empty($order->id))
        {
            return $this->updateOrder($request);
        }

        /* wrap in a transaction in case line item saves fail */
        DB::beginTransaction();
        try {
            $order->save();

            /* now handle line items */
            foreach ($order->order_items as $line) {
                $line->order_id = $order->id; // ensure lines get the new order id we just created

                $line->save();
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return json_encode(['Error' => $ex->getMessage()]);
        }
        DB::commit();

        /* cache order in the orders 'folder' for 10 minutes (longer in prod environment) */
        Cache::store('redis')->tags(['orders'])->put($order->id, json_encode($order), 600);

        return json_encode(['Success' => true, 'data' => $order]);
    }

    public function updateOrder(Request $request) : string
    {
        $good = false;

        // persist

        // expire cache/re-cache

        return json_encode(['Error' => 'Method Not Implemented']);  // create standardized response object, then return
    }

    /**
     * GET endpoint to retrieve Order with line items. Expects integer to be passed in, i.e. /api/1.0/order/125 and
     * returns JSON with status and order object on Success.
     * @param int $orderId
     * @return string
     */
    public function getOrder(int $orderId) : string
    {
        if (empty($orderId) || $orderId == 0) {
            return json_encode(['Error' => 'Invalid Order data.']);
        }

        /* check cache and return */
        $order = Cache::store('redis')->tags(['orders'])->get($orderId);

        /* not in cache, let's load */
        if (!$order) {
            $order = Order::with('order_items')->find($orderId);
            if ($order != null) {
                /* found it, cache it! */
                Cache::store('redis')->put($orderId, json_encode($order));
            }
        }

        if (empty($order)) { // null or false
            return json_encode(['Error' => 'Invalid Order Id.']);
        }

        return json_encode(['Success' => true, 'data' => $order]);
    }

    public function deleteOrder(int $orderId) : string
    {
        $good = false;

        // persist

        // expire cache/re-cache

        return json_encode(['Error' => 'Method Not Implemented']);  // create standardized response object, then return
    }

    public function searchOrders(Request $request)
    {
        if (!$request->ajax()) {
            return json_encode(['Error' => 'Invalid request.']);
        }

        $where = 0;

        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');
        $product = $request->input('product');

        //$orders = Order::with('order_items')->where('');

        $sql = 'SELECT id FROM public.order WHERE';

        if ($fname != null) {
            $sql .= " first_name LIKE " . DB::connection()->getPdo()->quote('%' . $fname . '%');
            $where++;
        }

        if ($lname != null) {
            if ($where) {
                $sql .= " AND";
            }
            $sql .= " last_name LIKE " . DB::connection()->getPdo()->quote('%' . $lname . '%');
            $where++;
        }

        if ($email != null) {
            if ($where) {
                $sql .= " AND";
            }
            $sql .= " email LIKE " . DB::connection()->getPdo()->quote('%' . $email . '%');
            //$where++;
        }

        try {
            $result = DB::select($sql);

            $orderNos = [];

            foreach ($result as $row) {
                $orderNos[] = $row->id;
            }

            $orders = Order::with('order_items')->whereIn('id', $orderNos)->get();
        } catch (\Exception $ex) {
            return json_encode(['Error' => $ex->getMessage()]);
        }

        return json_encode($orders);

    }

    /**
     * Added this for testing with Postman - need to pass/spoof the CSRF key. See routes/api.php for more info
     * @return string
     */
    public function getCSRF()
    {
        return Session::token();
    }
}
