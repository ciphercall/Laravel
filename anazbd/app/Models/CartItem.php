<?php

namespace App\Models;

use App\Seller;
use App\Traits\AuthScopes;
use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use AutoTimeStamp, AuthScopes;

    protected $fillable = ['cart_id', 'item_id', 'variant_id', 'seller_id', 'qty'];

    public function product()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
