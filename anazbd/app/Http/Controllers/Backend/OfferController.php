<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Requests\Offer\OfferRequest;
use App\Http\Requests\Offer\OfferUpdateRequest;
use App\Traits\ImageOperations;
use NabilAnam\SimpleUpload\SimpleUpload;

class OfferController extends Controller
{
    use ImageOperations;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::paginate(10);
        return view('admin.site-config.offers.index',compact('offers'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.offer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferRequest $request)
    {
        $all = $request->all();
        if($request->hasFile('image')){
            $previousImage = Offer::find($request->id);
            $all['image'] = $this->updateImage($previousImage,$request->image,'offers-image');
        }
        Offer::updateOrCreate(['id' => $request->id],$all);
        return back()->with('message','Offer image Inserted Successfully');
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
       $offer =Offer::find($id);
       return view('backend.offer.edit',compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OfferUpdateRequest $request,Offer $offer)
    {
        $all = $request->all();
        $all['image'] = (new SimpleUpload)
            ->file($request->image)
            ->dirName('banners')
            ->deleteIfExists($offer->image)
            ->save();

        $all = $offer->update($all);
        return back()->with('message', 'Offer Update Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
         $offer->delete();

        return back()->with('message', 'Deleted Successfully!');
    }
}
