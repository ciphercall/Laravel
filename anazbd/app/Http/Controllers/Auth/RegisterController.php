<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Traits\OTP;
use App\Traits\SMS;
use App\Traits\UserFallBackServiceTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class RegisterController extends Controller
{
    use SMS, OTP, UserFallBackServiceTrait;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    private $agent;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->agent = new Agent();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            // 'month' => ['required', 'string', 'max:10'],
            // 'day' => ['required', 'string', 'max:2'],
            // 'year' => ['required', 'string', 'max:4'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // dd($data);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            // 'day' => $data['day'],
            // 'month' => $data['month'],
            // 'year' => $data['year'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function completeRegistration(Request $request)
    {
//        $data = $request->all();
//        $user = User::where('mobile', $request->mobile)->first();
        $user = User::where('mobile', $request->mobile)->first();

        if ($request->has('otp') && ($request->otp != null) && $user != null) {
//            echo "register hit";
            $this->validate($request, [
                'mobile' => 'required|regex:/^01[0-9]{9}$/',
                'otp' => 'nullable|numeric|digits:6|in:'.$user->otp
            ]);

            $password = $request->password;
            $name = $request->name;

            if (Carbon::now()->diffInMinutes($user->otp_generated_at) < 2 ){
                // set otp to null
                $this->logInfo($user,$password);
                $user->update([
                    'name' => $name,
                    'otp' => $request->otp,
                    'status' => true,
                    'password' => Hash::make($password)
                ]);
                Auth::login($user);
                return redirect('/');
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'OTP Invalid'
                ],422);
            }

        } else if ($user == null) {
//            echo "OTP hit ";
            $this->validate($request, [
                'mobile' => 'required|regex:/^01[0-9]{9}$/|unique:users,mobile'
            ]);
            $otp = $this->generateOTP();
            $mobile = $request->mobile;
            $message2 = "Your OTP is $otp. It will be valid for two minutes.";

            User::create([
                'mobile' => $mobile,
                'otp' => $otp,
                'otp_generated_at' => Carbon::now()
            ]);
            $this->sendSMS($mobile, $message2);

            return response()->json([
                'status' => 'success',
                'msg' => 'OTP sent successfully.'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'msg' => 'Try again'
        ],422);

    }

    public function otpResend(Request $request)
    {
//        dd($request->all(),"resend");

        $this->validate($request,[
            'mobile' => 'required|regex:/^01[0-9]{9}$/|exists:users,mobile'
        ]);
        $user = User::where('mobile', $request->mobile)->first();
        if (Carbon::now()->diffInMinutes($user->otp_generated_at) > 2 ) {
            $otp = $this->generateOTP();
            $mobile = $request->mobile;
            $message = "Your OTP is $otp. It will be valid for two minutes.";

            $user->update([
                'otp' => $otp,
                'otp_generated_at' => Carbon::now()
            ]);
            $this->sendSMS($mobile, $message);

            return response()->json([
                'status' => 'success',
                'msg' => 'OTP re-sent successful.'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'msg' => 'Last OTP is still valid. Try again.'
        ],422);
    }


    public function showRegistrationForm()
    {
        if($this->agent->isDesktop()){
            return view('frontend.pages.login_reg_combined');
        }else{
            return view('mobile.pages.login_reg_combined');
        }
    }
}
