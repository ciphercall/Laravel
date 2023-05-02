<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Size\UpdateRequest;
use App\Models\City;
use App\Models\Division;
use Illuminate\Http\Request;

class AreaDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.area.index',[
            'divisions' => Division::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.area.create-division');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Division::create($request->all());
        return redirect()
            ->route('backend.area.index')
            ->with('message', 'Division created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.area.edit', [
            'division' => Division::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Division $division)
    {
        $division->update($request->all());
        return redirect()
            ->route('backend.area.index')
            ->with('message', 'Division updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Division::where('id', $id)->delete();
        } catch (\Exception $exception){
            return redirect()
                ->route('backend.area.index')
                ->with('message', 'Division is referenced in another place!');
        }
        return redirect()
            ->route('backend.area.index')
            ->with('message', 'Division deleted successfully!');

    }
}
