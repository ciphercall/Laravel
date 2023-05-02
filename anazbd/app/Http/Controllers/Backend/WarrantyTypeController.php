<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\WarrantyTypes\StoreRequest;
use App\Http\Requests\WarrantyTypes\UpdateRequest;
use App\Models\WarrantyType;
use Illuminate\Http\Request;

class WarrantyTypeController extends Controller
{
    public function index()
    {
        $warranties = WarrantyType::latest()->paginate(12);

        return view('admin.warranty.index', compact('warranties'));
    }

    public function create()
    {
        return view('backend.warranty-types.create');
    }

    public function store(StoreRequest $request)
    {
        WarrantyType::updateOrCreate(['id' => $request->id ],$request->all());

        return redirect()
            ->route('backend.product.warranty-types.index')
            ->with('message', 'Warranty type created successfully!');
    }

    public function edit($id)
    {
        $type = WarrantyType::where('id', $id)->first();
        return view('backend.warranty-types.edit', compact('type'));
    }

    public function update(UpdateRequest $request, $id)
    {
        WarrantyType::where('id', $id)->update($request->except('_token'));

        return redirect()
            ->route('backend.product.warranty-types.index')
            ->with('message', 'Warranty type updated successfully!');
    }

    public function destroy($id)
    {
        try {
            WarrantyType::where('id', $id)->delete();
        } catch (\Exception $e){
            return redirect()
                ->route('backend.product.warranty-types.index')
                ->with('error', 'Warranty type is referenced in another place!');
        }

        return redirect()
            ->route('backend.product.warranty-types.index')
            ->with('message', 'Warranty type deleted successfully!');
    }
}
