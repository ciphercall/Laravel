<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Rules\MatchOldPassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function changePassword()
    {
        return view('backend.auth.change_password');
    }

    public function AdminChangePassword($id)
    {
        return view('backend.auth.change_password_by_admin', ['user' => User::find($id)]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'     => ['required', new MatchOldPassword],
            'new_password'         => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
            return redirect()->back()->with('message', 'Password change successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Some error please check');
        }
    }

    public function AdminUpdatePassword(Request $request)
    {
        $request->validate([
            'new_password'     => ['required'],
            'confirm_password' => ['same:new_password'],
        ]);

        try {
            User::find($request->id)->update(['password' => Hash::make($request->new_password)]);
            return redirect()->back()->with('message', 'Password change successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Some error please check');
        }
    }
}
