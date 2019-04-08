<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModelWithValidation;

class OrderItem extends ModelWithValidation
{
    protected $table = 'order_item';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $rules = [
        'order_id' => 'required',
        'line_number' => 'required',
        'name' => 'required',
        'quantity' => 'required'
    ];

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }
}
