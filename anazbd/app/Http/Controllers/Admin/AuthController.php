<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    private function redirectTo()
    {
        return route('backend.dashboard.index');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function loggedOut()
    {
        return redirect()->route('admin.login.form');
    }
}
