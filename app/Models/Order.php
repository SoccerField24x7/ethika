<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function order_details()
    {
        $this->hasMany('App\Models\OrderItem', 'order_id', 'id');
    }
}
