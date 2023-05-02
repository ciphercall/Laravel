<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankInfo;
use Illuminate\Http\Request;

class BankInfoController extends Controller
{
    public function index()
    {
        $banks = BankInfo::latest()->paginate(15);
        return view('admin.banks.index',compact('banks'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string'
        ]);

        BankInfo::create([
            'name' => ucwords($request->name)
        ]);
        
        return redirect()->back();
    }

    public function delete($id)
    {
        BankInfo::find($id)->delete();
        return redirect()->back();
    }
}
