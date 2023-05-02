<?php

namespace App\Models;

use App\Seller;
use App\Traits\AuthScopes;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use AutoTimeStamp, AuthScopes;

    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    function seller(){
        return $this->belongsTo(Seller::class);
    }
}
