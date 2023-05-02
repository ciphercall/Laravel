<?php

namespace App\Models;

use App\Seller;
use App\Traits\AuthScopes;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use AutoTimeStamp, AuthScopes;

    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'detail_id');
    }
}
