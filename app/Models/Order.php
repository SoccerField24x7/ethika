<?php
namespace App\Models;

use App\Models\ModelWithValidation;
use App\Models\OrderItem;

class Order extends ModelWithValidation
{
    protected $table = 'order';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function order_items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'id');
    }

    public static function toObject(array $data, $obj = null) : Order
    {

        if ($obj == null) {
            $obj = new self();
        }

        if (isset($data['order_items'])) {
            $i = 0;
            foreach ($data['order_items'] as $line) {
                $orderItem = OrderItem::toObject($line, new OrderItem());
                $obj->order_items[$i++] = $orderItem;
            }
        }

        return parent::toObject($data, $obj);
    }
}
