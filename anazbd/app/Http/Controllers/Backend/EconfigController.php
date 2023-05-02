<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;

class EconfigController extends Controller 
{
   
    public function index()
    {
        $vats = SubCategory::paginate(25);
        return view('backend.econfig.vat',compact('vats'));
    }

    public function edit(SubCategory $subCategory)
    {
        return view('backend.econfig.vatedit',compact('subCategory'));
    }

    public function update(Request $request,SubCategory $subCategory)
    {
        $data = $request->all();
        $subCategory->update($data);
        return redirect()->route('backend.econfig.vat')->with('message','Vat update Successfully');
    }

    public function destroy(SubCategory $subCategory)
    {
        $data['vat'] = 0;
        $subCategory->update($data);
        return redirect()->route('backend.econfig.vat')->with('message','Vat Deleted Successfully');
    }

    // commission

    public function commissionindex()
    {
        $commissions = SubCategory::paginate(25);
        return view('backend.econfig.commission',compact('commissions'));
    }

    public function commissionedit(SubCategory $subCategory)
    {
        return view('backend.econfig.commissionedit',compact('subCategory'));
    }

    public function commissionupdate(Request $request,SubCategory $subCategory)
    {
        $data = $request->all();
        $subCategory->update($data);
        return redirect()->route('backend.econfig.commission')->with('message','Commission update Successfully');
    }

    public function commissiondestroy(SubCategory $subCategory)
    {
        $data['commission'] = 0;
        $subCategory->update($data);
        return redirect()->route('backend.econfig.commission')->with('message','Commission Deleted Successfully');
    }


}
