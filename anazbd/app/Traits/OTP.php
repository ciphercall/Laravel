<?php

namespace App\Traits;

trait OTP
{
    private function generateOTP($len = 6)
    {
        $otp = '';
        for ($i = 0; $i < $len; $i++) {
            if ($i == 0)
                $otp .= rand(1, 9);
            else
                $otp .= rand(0, 9);
        }
        return $otp;
    }
}
