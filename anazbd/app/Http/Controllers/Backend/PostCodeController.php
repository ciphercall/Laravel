<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Division;
use App\Models\PostCode;
use Illuminate\Http\Request;
use DB;

class PostCodeController extends Controller
{
    public function getCity($divId){
        $data = City::where('division_id', $divId)->get();
        return json_encode($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.area.post_code.index', [
            'postCodes' => DB::table('post_codes')
                    ->join('divisions', 'post_codes.division_id', '=', 'divisions.id')
                    ->join('cities', 'post_codes.city_id', '=', 'cities.id')
                    ->select('post_codes.*', 'divisions.name as division_name', 'cities.name as city_name')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.area.post_code.create', [
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
        PostCode::create($request->all());
        return redirect()
            ->route('backend.area.post_code.index')
            ->with('message', 'Post-Code created successfully!');
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
    public function edit($id=null)
    {
        return view('backend.area.post_code.edit',[
            'divisions' => Division::all(),
            'postCode'  => PostCode::find($id),
            'allCity' => City::all()

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostCode $id)
    {
        $id->update($request->all());
        return redirect()
            ->route('backend.area.post_code.index')
            ->with('message', 'post-code updated successfully!');
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
            PostCode::where('id', $id)->delete();
        }catch (\Exception $exception) {
            return redirect()
                ->route('backend.area.post_code.index')
                ->with('message', 'Post-code not found!');
        }
        return redirect()
            ->route('backend.area.post_code.index')
            ->with('message', 'Post-code deleted successfully!');
    }


}
