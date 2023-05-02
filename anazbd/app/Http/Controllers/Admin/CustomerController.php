<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(15);
        return view('admin.users.customers.index',compact('users'));
    }

    public function create()
    {
        return view('admin.users.customers.create');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.customers.edit',compact('user'));
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name' => 'nullable|string|min:6',
            'email' => 'nullable|email',
            'mobile' => 'nullable|regex:/^01[0-9]{9}$/|unique:users,mobile,'.$id,
            'password' => 'nullable|min:6|confirmed'
        ]);
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => $request->password ? Hash::make($request->password) : $user->password
        ]);
        return redirect()->back()->with('success','Data Updated');
    }
    public function toggleStatus($id)
    {
        $user = User::find($id);
        $user->status = !$user->status;
        $user->update();

        return redirect()->back()->with('success',"User Status Updated.");
    }

    public function destroy($id){
        try {
            User::find(az_unhash($id))->delete();
        }catch (\Exception $exception){
            Session::flash('error','User Cannot be deleted.');
            return redirect()->back();
        }
        Session::flash('success','User deleted.');
        return redirect()->back();
    }
}
