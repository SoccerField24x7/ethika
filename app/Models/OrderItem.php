<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelWithValidation;

class OrderItem extends ModelWithValidation
{
    protected $table = 'order_item';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }
}
