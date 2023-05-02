<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('roles')->latest()->paginate(20);
        $roles = Role::get();
        return view('admin.users.admins.index',compact('admins','roles'));
    }

    public function store(Request $request)
    {
        if($request->id){
            $this->validate($request,[
                'id' => 'required|numeric',
                'name' => 'required|string',
                'email' => 'required|email|unique:admins,email,'.$request->id,
                'password' => 'nullable|min:8|confirmed',
                'roles.*' => 'required|numeric'
            ]);
        }else{
            $this->validate($request,[
                'name' => 'required|string',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|min:8|confirmed',
                'roles.*' => 'required|numeric'
            ]);
        }
        try{
            DB::beginTransaction();
            $admin = Admin::updateOrCreate([
                'id' => $request->id
            ],[
                'name' => $request->name,
                'email' => $request->email,
                'is_super' => $request->is_super,
            ]);

            if($request->password != null && strlen($request->password) > 0){
                $admin->password = Hash::make($request->password);
                $admin->update();
            }
            $admin->roles()->sync($request->roles);
            Cache::flush();
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            dd($e);
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        Admin::findOrFail($id)->delete();
        Cache::flush();
        return redirect()->back();
    }
}
