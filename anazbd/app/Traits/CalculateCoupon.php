<?php

namespace App\Traits;

use App\Models\Coupon;
use App\Models\UserCoupon;

trait CalculateCoupon
{
    private function calculateCouponValue($coupon_code, $subtotal)
    {
        /* 
            Coupon effect on Checklist
            
            1. Categories
            2. sub categories
            3. users
            4. location
            5. product
            6. seller
            7. anaz empire
            8. anaz spotlight
            9. Child category
            10. Subtotal
            11. delivery charge
        */
        $result = [
            'model'     => null,
            'value'     => 0,
            'coupon_on' => 'subtotal',
            'type' => 'amount'
        ];

        if (!$coupon_code || $coupon_code == '')
            return $result;

        $coupon = Coupon::where('name', $coupon_code)
            ->whereValidForToday()
            ->first();

        if ($coupon) {
            $user_coupon_count = UserCoupon::whereAuthUser()->where('coupon_id', $coupon->id)->count();
            if ($user_coupon_count < $coupon->max_use) {
                $value = $coupon->value;
                if ($coupon->type == 'percent')
                    $value = round($subtotal * ($coupon->value / 100));

                $result['model'] = $coupon;
                $result['coupon_on'] = $coupon->coupon_on;
                $result['value'] = round($value < $subtotal ? $value : 0);
                $result['type'] = $coupon->type;
            }
        }

        return $result;
    }
}
