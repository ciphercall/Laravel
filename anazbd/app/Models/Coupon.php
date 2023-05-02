<?php

namespace App\Models;

use App\Traits\AutoTimeStamp;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use AutoTimeStamp;

    protected $guarded = ['id'];

    protected $dates = ['from', 'to'];

    // protected $fillable = [
    //     'name', 'value', 'type', 'on', 'min_amount', 'from', 'to', 'is_active', 'max_use'
    // ];

    public function scopeWhereValidForToday($q)
    {
        $q->whereDate('from', '<=', date('Y-m-d'))
            ->whereDate('to', '>=', date('Y-m-d'))
            ->where('is_active', true);
    }

    public function user_coupons()
    {
        return $this->hasMany(UserCoupon::class);
    }

    public function getValueAttribute($value)
    {
        return round($value);
    }

    public function couponExtra()
    {
        return $this->hasMany(CouponExtra::class);
    }
}
