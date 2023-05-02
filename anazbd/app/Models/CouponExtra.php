<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponExtra extends Model
{
    protected $fillable = [
        'coupon_id',
        'couponable_id',
        'couponable_type',
        'type',
        'coupon_on',
        'value',
        'min_amount'
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function couponable()
    {
        return $this->morphTo();
    }
}
