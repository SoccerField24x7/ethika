<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function order()
    {
        $this->hasOne('App\Models\Order', 'id', 'order_id');
    }
}
