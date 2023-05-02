<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SellerBusinessAddress;
use App\Models\SellerProfile;
use App\Models\SellerReturnAddress;
use App\Seller;
use App\Traits\OTP;
use App\Traits\SMS;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class SellerLoginController extends Controller
{
    use AuthenticatesUsers, SMS, OTP;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('seller.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('seller');
    }

    protected function loggedOut()
    {
        return redirect()->route('seller.login.form');
    }

    public function username()
    {
        return 'mobile';
    }

    private function redirectTo()
    {
        return route('seller.dashboard.index');
    }

    public function showRegisterForm()
    {
        return view('seller.auth.register');
    }

    public function register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|min:3',
            'mobile' => 'required|numeric|regex:/^01[0-9]{9}$/|unique:sellers,mobile',
            'type' => 'required',
            'shop_name' => 'required|string|unique:sellers,shop_name|min:3',
            'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
            // 'otp' => 'required|string|min:6',
            'terms' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);
        // dd($request->all());
        /* 
            OLD OTP version
        */
        // Seller::where('mobile', $request->mobile)
        //     ->where('otp', $request->otp)
        //     ->update([
        //         'name' => $request->name,
        //         'type' => $request->type,
        //         'image' => 'defaults/user.png',
        //         'shop_name' => $request->shop_name,
        //         'password' => Hash::make($request->password),
        //         'otp' => null
        //     ]);
        /* 
            New version
        */
        Seller::create([
            'name' => $request->name,
            'type' => $request->type,
            'mobile' => $request->mobile,
            'image' => 'defaults/user.png',
            'shop_name' => $request->shop_name,
            'password' => Hash::make($request->password),
            'status' => false,
        ]);
        return redirect()->route('seller.login.form')->with('message', 'You have registered successfully! We will contact you soon.');
    }

    //// OTP Routes ////

    public function sendOTP(Request $request)
    {
        $request->validate([
            'mobile' => 'required|regex:/^01[0-9]{9}$/|unique:sellers,mobile'
        ]);

        $otp = $this->generateOTP();
        try {
            DB::beginTransaction();
            Seller::updateOrCreate(['mobile' => $request->mobile], ['otp' => $otp,'status' => false]);
            $this->sendSMS($request->mobile, "ভেরিফিকেশন কোড #" . $otp);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false]);
        }

        return response()->json(['status' => true]);
    }

    public function verifyOTP(Request $request)
    {
        $type = null;
        $request->validate([
            'mobile' => 'required|regex:/^01[0-9]{9}$/',
            'otp' => 'required|string|min:6'
        ]);

        $seller = Seller::where('mobile', $request->mobile)->where(['otp' => $request->otp])->first();

        if ($seller) {
            $seller->otp = null;
            $seller->save();
            session()->put('verified', true);
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    
}
