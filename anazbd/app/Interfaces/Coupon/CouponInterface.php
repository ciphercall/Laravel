<?php

namespace App\Interfaces\Coupon;
use App\Models\Coupon;

interface CouponInterface{
    /* 
        Applies Coupon on Cart
    */
    public function apply();

    // /* 
    //     Checks and returns coupon on

    //     returns mixed type
    // */
    // public function couponOn();
}