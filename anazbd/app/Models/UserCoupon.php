<?php

namespace App\Models;

use App\Traits\AuthScopes;
use App\Traits\AutoTimeStamp;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    use AutoTimeStamp, AuthScopes;

    protected $guarded = ['id'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'user_coupon_id');
    }
}
