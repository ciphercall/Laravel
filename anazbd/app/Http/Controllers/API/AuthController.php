<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\OTP;
use App\Traits\SMS;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use SMS, OTP;

    public function login(){

        if(Auth::attempt(['mobile' => request('mobile'), 'password' => request('password')])){
            $user = Auth::user();
            if($user->status){
                $token =  $user->createToken('anazbd@321')->accessToken;
                $user['token'] = $token;
                $user->load('division','city','area');
                return response()->json([
                    'status' => "success",
                    'msg' => "User Authenticated successfully.",
                    "data" => $user
                ], 200);
            }else{
                return response()->json([
                    'status' => "failed",
                    'msg' => "User Account is not active. Contact Adminstration",
                    "data" => []
                ], 200);
            }
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    
    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'mobile' => 'required|regex:/^01[0-9]{9}$/',
            'mobile' => 'unique:users,mobile',
            'name' => 'required|string',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=> 'failed',
                'msg' => 'failed to validate request.',
                'data' => $validator->errors()
            ], 400);
        }
        $otp = $this->generateOTP();

        try {
            User::updateOrCreate(['mobile' => $request->mobile], [
                'otp' => $otp,
                'name' => $request->name,
                'password' => Hash::make($request->password)
                ]);
            $this->sendSMS($request->mobile, "ভেরিফিকেশন কোড #" . $otp);
        } catch (\Exception $e) {
            return response()->json([
                'status'=> 'error',
                'msg' => 'Unable to send otp',
                'data' => $e
            ], 400);
        }

        return response()->json([
            'status'=> 'success',
            'msg' => 'Otp Sent successfully',
            'data' => [$otp]
        ], 200);
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'mobile' => 'required|regex:/^01[0-9]{9}$/',
            'otp' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 'failed',
                'msg' => 'failed to validate request.',
                'data' => $validator->errors()
            ], 400);
        }
        $user = User::where('mobile', $request->mobile)->where(['otp' => $request->otp])->first();

        if ($user) {
            $token = $user->createToken('anazbd@321')->accessToken;
            $user->otp = null;
            $user->status = true;
            $user->platform_origin = "App";
            $user->save();
            $user['token'] = $token;
            return response()->json([
                'status' => "success",
                'msg' => "User Registered successfully.",
                "data" => $user
            ], 200);
        }
        return response()->json([
            'status' => "error",
            'msg' => "User not found.",
            "data" => []
        ], 401);
    }

    public function logout(Request $request)
    {
        if(request()->user()->token()){
            request()->user()->token()->revoke();
            return response()->json(["message"=>"success"]);
        }

        return response()->json(["message"=>"error"],400);
    }
}
