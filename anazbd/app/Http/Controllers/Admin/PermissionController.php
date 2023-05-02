<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::latest()->paginate(20);
        return view('admin.permissions.index',compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string',
            'description' => 'nullable|string|max:191'
        ]);
        
        Permission::updateOrCreate([
            'id' => $request->id
        ],[
            'name' => str_replace(" ","_",strtolower($request->name)),
            'description' => $request->description
        ]);
        Cache::flush();
        return redirect()->back();
    }

    public function delete($id)
    {
        Permission::findOrFail($id)->delete();
        Cache::flush();
        return redirect()->back()->with('message','Permission Deleted');

    }
}
