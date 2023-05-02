<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DeliverySize;
use Illuminate\Http\Request;

class DeliverySizeController extends Controller
{
    public function index()
    {
        $sizes = DeliverySize::latest()->paginate(12);
        return view('admin.delivery_size.index', compact('sizes'));
    }

    public function create()
    {
        return view('backend.econfig.delivery-size.create');
    }

    public function store(Request $request)
    {
        DeliverySize::updateOrCreate(['id'=>$request->id],$request->except('_token'));
        return redirect()->route('backend.econfig.delivery-size.index')->with('message', 'Size created successfully!');
    }

    public function edit($id)
    {
        $size = DeliverySize::find($id);
        return view('backend.econfig.delivery-size.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        DeliverySize::where('id', $id)->update($request->except('_token'));

        return redirect()->route('backend.econfig.delivery-size.index')->with('message', 'Size updated successfully');
    }

    public function destroy($id)
    {
        DeliverySize::destroy($id);

        return redirect()->route('backend.econfig.delivery-size.index')->with('message', 'Size deleted successfully!');
    }
}
