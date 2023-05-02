<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Customer\LoginRequest;
use App\Http\Requests\Auth\Customer\RegisterRequest;
use App\Http\Requests\Auth\Customer\SendOTPRequest;
use App\Http\Requests\Auth\Customer\VerifyOTPRequest;
use App\Mail\OTPGenerated;
use App\Providers\RouteServiceProvider;
use App\Traits\CalculateCart;
use App\Traits\DetectUsernameType;
use App\Traits\OTP;
use App\Traits\SMS;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use function GuzzleHttp\uri_template;

class LoginController extends Controller
{
    use AuthenticatesUsers, DetectUsernameType, SMS, OTP, CalculateCart;

    protected $redirectTo = RouteServiceProvider::HOME;
    private $agent ;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->agent = new Agent();
    }

    public function redirectTo(){

        return url($this->redirectTo);
    }

    public function username()
    {
        return 'username';
    }

    protected function credentials(Request $request)
    {
        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->username, 'password' => $request->password, 'status' => true];
        } else {
            return ['mobile' => $request->username, 'password' => $request->password, 'status' => true];
        }
    }

    protected function authenticated(Request $request, $user)
    {
        $arr = explode('/',$request->redirect);
        if(array_pop($arr) != ''){
            $this->redirectTo = $request->redirect;
        }
        $this->calculateCart();
        session()->put('cart', $this->calculateCart());
        return redirect()->intended($this->redirectPath());
    }

    //// Auth Routes ////

    public function showLoginForm()
    {

        if (auth('web')->check())
        {
            return redirect()->to('/');
        }
        if($this->agent->isDesktop()){
            return view('frontend.pages.login_reg_combined');
        }else{
            return view('mobile.pages.login_reg_combined');
        }
    }

    public function showRegisterForm()
    {
        if (auth('web')->check())
        {
            return redirect()->to('/');
        }
        if($this->agent->isDesktop()){
            return view('frontend.pages.register');
        }else{
            return view('mobile.pages.register');
        }
    }

    public function showIframeLoginForm()
    {
        return view('frontend.iframe.login-register');
    }

    public function register(RegisterRequest $request)
    {
        if (auth('web')->check())
        {
            return redirect()->to('/');
        }

        if ($this->registerUser($request)) {
            notify()->success('You have registered successfully! Please sign in!');
            return redirect()->route('frontend.user.login.form');
        }

        notify()->error('Verification code do not match!');
        return back();
    }

    //// AJAX Routes ////
    public function ajaxRegister(RegisterRequest $request)
    {
        if ($this->registerUser($request)) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function ajaxLogin(LoginRequest $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return response()->json(['status' => false]);
        }

        if ($this->attemptLogin($request)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            return response()->json(['status' => true, 'token' => csrf_token()]);
        }

        $this->incrementLoginAttempts($request);
        return response()->json(['status' => false]);
    }

    public function sendOTP(SendOTPRequest $request)
    {
        if($request->username_type == "Mobile"){
            $this->validate($request,[
                'username' => 'unique:users,mobile'
            ]);
        }else{
            $this->validate($request,[
                'username' => 'unique:users,email'
            ]);
        }

        $otp = $this->generateOTP();
        try {
            if ($request->username_type == 'Email') {
                User::updateOrCreate(['email' => $request->username], ['otp' => $otp]);
                Mail::to($request->username)->send(new OTPGenerated($otp));
            } else {
                User::updateOrCreate(['mobile' => $request->username], ['otp' => $otp]);
                $this->sendSMS($request->username, "ভেরিফিকেশন কোড #" . $otp);
            }
        } catch (\Exception $e) {
//            return response()->json($e->getmessage());
             return response()->json(['status' => false]);
        }

        return response()->json(['status' => true]);
    }

    public function verifyOTP(VerifyOTPRequest $request)
    {
        $user = null;
        if ($request->username_type == 'Email') {
            $user = User::where('email', $request->username)->where(['otp' => $request->otp])->first();
        } else {
            $user = User::where('mobile', $request->username)->where(['otp' => $request->otp])->first();
        }

        if ($user) {
            $user->otp = null;
            $user->save();
            session()->put('verified', true);
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }

    //// helpers ////
    private function registerUser(RegisterRequest $request)
    {
        $user = User::where('otp', $request->otp);
        if ($request->username_type == 'Email') {
            $user->where('email', $request->username);
        } else {
            $user->where('mobile', $request->username);
        }
        $user = $user->first();

        if ($user) {
            $user->otp = null;
            $user->name = $request->full_name;
            $user->day = $request->day;
            $user->month = $request->month;
            $user->year = $request->year;
            $user->gender = $request->gender;
            $user->password = Hash::make($request->password);
            $user->subscription = $request->filled('subscription');
            $user->division_id = 1; // Dhaka
            $user->city_id = 98; // North
            $user->post_code_id = 606; // Abul Hotel
            $user->status = true;
            $user->save();
            return true;
        }
        return false;
    }

     public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
