<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Http\Requests\Color\StoreRequest;
use App\Http\Requests\Color\UpdateRequest;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::latest()->paginate(25);
        return view('admin.colors.index',compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        Color::updateOrCreate([
            'id' => $request->id
        ],$data);
        return redirect()
            ->route('backend.product.colors.index')
            ->with('message', 'Color created successfully!');

    }

    public function edit(Color $color)
    {
        return view('backend.colors.edit', compact('color'));
    }

    public function update(UpdateRequest $request, Color $color)
    {
        $all = $request->all();

        $color->update($all);

        return redirect()
            ->route('backend.product.colors.index')
            ->with('message', 'Color updated successfully!');
    }

   
    public function destroy(Color $color)
    {
         try {
            $color->delete();
        } catch (\Exception $e){
            return redirect()
                ->route('backend.product.sizes.index')
                ->with('error', 'color is referenced in another place!');
        }

        return redirect()
            ->route('backend.product.brands.index')
            ->with('message', 'color deleted successfully!');
    }
    
}
