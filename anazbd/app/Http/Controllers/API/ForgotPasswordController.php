<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\OTP;
use App\Traits\SMS;
use App\Traits\UserFallBackServiceTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;


class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails, OTP, SMS, UserFallBackServiceTrait;

    public function sendOTP(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|exists:users,mobile'
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

    public function reset(Request $request)
    {
        $this->validate($request,[
            'mobile' => 'required|regex:/^01[0-9]{9}$/|exists:users,mobile',
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:4|confirmed',
        ]);

        $user = User::where('mobile',$request->mobile)->first();
        if($user->otp === $request->otp && Carbon::now()->diffInMinutes($user->otp_generated_at) < 2 ){
            $this->logInfo($user,$request->password);
            $user->password = Hash::make($request->password);
            $user->update();
            return response()->json([
                'status' => 'success',
                'msg' => 'Password Reset Successfull',
                'data' => []
            ],200);
        }else{
            return response()->json([
                'status' => 'error',
                'msg' => 'Something went wrong',
                'data' => []
            ],422);
        }
    }
}
