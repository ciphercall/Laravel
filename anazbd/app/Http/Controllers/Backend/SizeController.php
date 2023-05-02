<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use App\Http\Requests\Size\StoreRequest;
use App\Http\Requests\Size\UpdateRequest;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->paginate(25);
        return view('admin.sizes.index',compact('sizes'));
    }

    public function create()
    {
        return view('backend.sizes.create');
    }

    public function store(StoreRequest $request)
    {
        $all = $request->all();

        Size::updateOrCreate(['id'=>$request->id],$all);

        return redirect()
            ->back()
            ->with('message', 'Size created successfully!');
    }



    public function edit(Size $size)
    {
        return view('backend.sizes.edit', compact('size'));
    }


    public function update(UpdateRequest $request, Size $size)
    {
        $all = $request->all();

        $size->update($all);

        return redirect()
            ->route('backend.product.sizes.index')
            ->with('message', 'Size updated successfully!');
    }


    public function destroy(Size $size)
    {
        try {
            $size->delete();
        } catch (\Exception $e){
            return redirect()
                ->back()
                ->with('error', 'size is referenced in another place!');
        }

        return redirect()
            ->back()
            ->with('message', 'size deleted successfully!');
    }

}
