<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
