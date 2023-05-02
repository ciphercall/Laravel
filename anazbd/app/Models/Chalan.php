<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chalan extends Model
{
    protected $fillable = [
        'order_id','order_no','type','subtotal','total','shipping_charge','chalan_no','status','delivered_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function chalan_items()
    {
        return $this->hasMany(ChalanItem::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
