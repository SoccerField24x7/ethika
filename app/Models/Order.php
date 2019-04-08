<?php
namespace App\Models;

use App\Models\ModelWithValidation;

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

//        if (isset($vals->order_items)) {
//            foreach ($vals->order_items as $line) {
//
//            }
//        }

        return parent::toObject($data, $obj);
    }
}
