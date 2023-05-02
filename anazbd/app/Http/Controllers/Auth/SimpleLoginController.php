<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\OTP;
use App\Traits\SMS;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SimpleLoginController extends Controller
{
    use OTP, SMS;

    public function sendOTP(Request $request)
    {
        $this->validate($request,[
            'mobile' => 'required|regex:/^01[0-9]{9}$/|exists:users,mobile'
        ]);
        
        // get user
        $user = User::where('mobile',$request->mobile)->where('status',true)->firstOrFail();

        // generate token & otp
        $otp = $this->generateOTP(4);
        $token = Str::random(32);
        
        // update user table with otp and token
        $user->update([
            'login_otp' => $otp,
            'login_token' => $token,
            'login_token_generated_at' => now(),
        ]);

        // send otp
        $this->sendSMS($request->mobile, "Your OTP is #" . $otp.". This OTP will be valid for 5 minutes");    }

        // return response with login token

    public function login(Request $request)
    {
        # code...
    }
}
