<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use App\Seller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use AutoTimeStamp,SoftDeletes;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function detail()
    {
        return $this->belongsTo(OrderDetail::class, 'detail_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class,'seller_id');
    }

    //scopes

    public function scopeWithProductName($query)
    {
        return $query->addSelect([

            'product_name' => Item::select('name')->whereColumn('id','order_items.item_id')->limit(1),

            ]);
    }
}
