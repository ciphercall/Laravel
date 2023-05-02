<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Banner\BannerRequest;
use App\Http\Requests\Banner\BannerUpdateRequest;
use NabilAnam\SimpleUpload\SimpleUpload;
use App\Models\Banner;
use App\Traits\ImageOperations;

class BannerController extends Controller
{
    use ImageOperations;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::latest()->paginate(10);
        // dd($banners);
         return view('admin.site-config.banner.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stores(BannerRequest $request)
    {
        // dd($request->all());
        $all = $request->all();

        if($request->hasFile('image')){
            if($request->has('id')){
                $all['image'] = $this->updateImage(Banner::findOrFail($request->id)->image,$request->image,"banners","banner",true);
            }else{
                $all['image'] = $this->saveImage("banners",$request->image,"banner",true);
            }
        }

        Banner::updateOrCreate(['id'=>$request->id],$all);

        return back()->with('message', 'Banner Added Successfully!');
    }


    public function status(Request $request ,$banner_id)
    {
        $banner = Banner::find($banner_id);
        $banner->status = $request->status;
        $banner->save();
        return response()->json(['success'=>'Status change successfully.']);
    }


    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('backend.banner.edit',compact('banner'));

    }


    public function update(BannerUpdateRequest $request, Banner $banner)
    {
        $all = $request->all();

        $all['image'] = $this->updateImage($banner->image,$request->image,"banners","banner",true);

        $all = $banner->update($all);
        return back()->with('message', 'Banner Update Successfully!');
    }


    public function destroy(Banner $banner)
    {
        $this->deleteImage($banner->image);
        $banner->delete();

        return back()->with('message', 'Banner Deleted Successfully!');

    }
}
