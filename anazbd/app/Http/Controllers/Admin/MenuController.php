<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Models\Permission;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $permissions = Permission::get(['id','name']);
        $menus = Menu::with('permissions:id,name')->latest()->paginate(25);
        $parentMenus = Menu::where('parent_id',NULL)->get(['id','name']);
        $dirtyMenus = Menu::with('submenus')->get();

        return view('admin.menus.index',compact('permissions','menus','parentMenus','dirtyMenus'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required','string'],
            'route' => ['required','string','unique:menus,route'],
            'icon' => ['nullable','string'],
            'parent_id' => ['nullable','numeric','exists:menus,id'],
            'permissions.*' => ['nullable','numeric'],
            'is_new_panel' => ['required']
        ]);

        $menu = Menu::create([
            'name' => ucwords($request->name),
            'route' => strtolower($request->route),
            'icon' => $request->icon ?? 'fa fa-list',
            'parent_id' => $request->parent_id,
            'is_new_panel' => $request->is_new_panel
        ]);

        if($request->has('permissions')){
            $menu->permissions()->sync($request->permissions);
        }
        return redirect()->back();
    }
    public function update(Request $request)
    {
        if($request->has('id')){
            $this->validate($request,[
                'name' => ['required','string'],
                'route' => ['required','string','unique:menus,route,'.$request->id],
                'icon' => ['nullable','string'],
                'parent_id' => ['nullable','numeric','exists:menus,id'],
                'permissions.*' => ['nullable','numeric'],
                'is_new_panel' => ['required']
            ]);

            $menu = Menu::findOrFail($request->id);
            $menu->update([
                'name' => ucwords($request->name),
                'route' => strtolower($request->route),
                'icon' => $request->icon ?? 'fa fa-list',
                'parent_id' => $request->parent_id,
                'is_new_panel' => $request->is_new_panel
            ]);
            if($request->has('permissions')){
                $menu->permissions()->sync($request->permissions);
            }
            return redirect()->back();

        }
        return redirect()->back();
    }

    public function delete($id)
    {
        Menu::findOrFail($id)->delete();
        return redirect()->back();
    }
}
