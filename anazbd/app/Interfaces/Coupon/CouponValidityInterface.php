<?php

namespace App\Interfaces\Coupon;

use App\Models\Coupon;

interface CouponValidityInterface{
    /* 
        checks if the coupon is valid for cart and user

        returns bool
    */
    public function checkValidity() : bool;
}