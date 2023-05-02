<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Units\StoreRequest;
use App\Http\Requests\Units\UpdateRequest;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->paginate(5);

        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        return view('backend.units.create');
    }

    public function store(StoreRequest $request)
    {
        Unit::updateOrCreate(['id' => $request->id],$request->all());

        return redirect()
            ->route('backend.product.units.index')
            ->with('message', 'Unit created successfully!');
    }

    public function edit(Unit $unit)
    {
        return view('backend.units.edit', compact('unit'));
    }

    public function update(UpdateRequest $request, Unit $unit)
    {
        $unit->update($request->all());

        return redirect()
            ->route('backend.product.units.index')
            ->with('message', 'Unit updated successfully!');
    }

    public function destroy($id)
    {
        try {
            Unit::where('id', $id)->delete();
        } catch (\Exception $e){
            return redirect()
                ->route('backend.product.units.index')
                ->with('error', 'Unit is referenced in another place!');
        }

        return redirect()
            ->route('backend.product.units.index')
            ->with('message', 'Unit deleted successfully!');
    }
}
