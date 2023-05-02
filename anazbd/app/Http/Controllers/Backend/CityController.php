<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.area.city.index', [
            'cities' => DB::table('cities')
                            ->join('divisions', 'cities.division_id', '=', 'divisions.id')
                            ->select('cities.*', 'divisions.name as division_name')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.area.city.create', [
            'divisions' => Division::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         City::create($request->all());
        return redirect()
            ->route('backend.area.city.index')
            ->with('message', 'City created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=null)
    {
        return view('backend.area.city.edit',[
            'divisions' => Division::all(),
            'city'      => City::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $id)
    {
        $id->update($request->all());
        return redirect()
            ->route('backend.area.city.index')
            ->with('message', 'City updated successfully!');
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
            City::where('id', $id)->delete();
        }catch (\Exception $exception) {
            return redirect()
                ->route('backend.area.city.index')
                ->with('message', 'City deleted successfully!');
        }
        return redirect()
            ->route('backend.area.city.index')
            ->with('message', 'City deleted successfully!');
    }
}
