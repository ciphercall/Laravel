<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class BackendLoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function loggedOut()
    {
        return redirect()->route('backend.login.form');
    }

    private function redirectTo()
    {
        return route('backend.dashboard.index');
    }
}
