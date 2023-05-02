<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {

        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('delivery.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('delivery');
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            // dd($request->all());
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);

    }

    protected function loggedOut()
    {
        return redirect()->route('delivery.login.form');
    }

    private function redirectTo()
    {
        return route('delivery.dashboard.index_1');
    }
    public function index()
    {
        return view('delivery.dashboard.index');
    }
}
