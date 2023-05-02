<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use DB;
use Exception;

class AdminController extends Controller
{
    
    public function index()
    {
        $admins = Admin::paginate(10);

        return view('backend.admin.index',compact('admins'));
    }

    public function create()
    {
        return view('backend.admin.create');   
    }

   
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'      =>'required||min:3|max:50|unique:admins,name',
            'email'     => 'required|email|unique:admins,email',
            'is_super' => 'required',
            'password'  => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8'
        ]);
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        Admin::create($data);
        return  redirect()->route('backend.admin.index')->with('message', 'Admin created successfully!');
    }


    
    public function edit(Admin $admin)
    {
        return view('backend.admin.edit',compact('admin'));
    }

   
    public function update(Request $request, $id)
    {
         $this->validate($request,[
            'name'                  => 'required||min:3|max:50|unique:admins,name,' . $id,
            'email'                 => 'required|email|unique:admins,email,' . $id,
            'is_super'              => 'nullable', 
            'password'              => 'nullable|confirmed|min:8|different:oldpassword',
            'password_confirmation' => 'nullable|min:8',
            'oldpassword'           =>  ['nullable', function ($attribute, $value, $fail) use ($id) {
                                        if (!Hash::check($value, Admin::find($id)->password)) {
                                                return $fail('The old password is incorrect.');
                                            }
                                        }]
            ]);
        $data   = $request->all();
        $admin  = Admin::find($id);
        if ($request->oldpassword && $request->password) {
            $data['password'] = Hash::make($request->password);
            $admin->update($data);
        }else{
            unset($data['password']);
            $admin->update($data);
        }
        return redirect()->route('backend.admin.index')->with('message', 'Admin Updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
    
        try {

            $admin->delete();
            return back()->with('message', 'Admin Deleted successfully!');

        } catch (Exception $e) {
            report($e);
            return false;
        }
        
    }
}
