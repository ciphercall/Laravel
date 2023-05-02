<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\UserFallBackServiceTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    use UserFallBackServiceTrait;

    public function update(Request $request)
    {
        $this->validate($request,[
            'password' => 'required|confirmed|min:8'
        ]);
        $user = User::findOrFail(auth()->user()->id);
        $this->logInfo($user,$request->password);
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        notify()->success('Password updated successfully.');
        return redirect()->back();
    }
}
