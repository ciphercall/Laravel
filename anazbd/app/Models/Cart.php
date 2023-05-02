<?php

namespace App\Models;

use App\Traits\AuthScopes;
use App\Traits\AutoTimeStamp;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use AutoTimeStamp, AuthScopes;

    protected $fillable = ['user_id', 'coupon','redeem'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cart_items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
}
