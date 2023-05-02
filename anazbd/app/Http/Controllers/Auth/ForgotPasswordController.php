<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\OTP;
use App\Traits\SMS;
use App\Traits\UserFallBackServiceTrait;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use UserFallBackServiceTrait;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails, OTP, SMS;

    public function sendOTP(Request $request)
    {
        session(['resettingPassword' => false]);
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|regex:/^01[0-9]{9}$/|exists:users,mobile'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'msg' => 'Validation Failed',
                'data' => $validator->errors()
            ],422);
        }
        $otp = $this->generateOTP();
        try{
            User::where('mobile',$request->mobile)->first()->update([
                'otp' => $otp,
                'otp_generated_at' => Carbon::now()
            ]);
            $this->sendSMS($request->mobile,"Your onetime OTP is ".$otp);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'msg' => 'Something went wrong',
                'data' => []
            ],422);
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'OTP sent',
            'data' => []
        ]);
    }

    public function resetPassword(Request $request)
    {
        session(['resettingPassword' => true]);
        $this->validate($request,[
            'mobile' => 'required|regex:/^01[0-9]{9}$/|exists:users,mobile',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('mobile',$request->mobile)->first();
        if($user->otp === $request->otp && Carbon::now()->diffInMinutes($user->otp_generated_at) < 2 ){
            $this->logInfo($user,$request->password);
            $user->password = Hash::make($request->password);
            $user->update();
            session(['resettingPassword' => false]);
            return redirect()->back()->with('success','Password Updated. Login Now.');
        }else{
            return redirect()->back()->with('error','OTP Invalid. Try Again')->withInput($request->all());
        }
    }
}
