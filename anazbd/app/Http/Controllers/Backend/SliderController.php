<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Slider\SliderRequest;
use App\Http\Requests\Slider\SliderUpdateRequest;
use App\Models\Slider;
use App\Traits\ImageOperations;
use NabilAnam\SimpleUpload\SimpleUpload;

class SliderController extends Controller
{
    use ImageOperations;
    public function index()
    {
        $sliders = Slider::latest()->paginate(10);
         return view('admin.site-config.slider.index',compact('sliders'));
    }


    public function create()
    {
        return view('backend.slider.create');
    }


    public function store(SliderRequest $request)
    {
        $all = $request->all();
        if($request->hasFile('image')){
            if($request->has('id')){
                $all['image'] = $this->updateImage(Slider::findOrFail($request->id)->image,$request->image,"sliders","slider",true);
            }else{
                $all['image'] = $this->saveImage("sliders",$request->image,"slider",true);
            }
        }
        $all['status'] = $request->has('status') ? true : false;
        Slider::updateOrCreate(['id' => $request->id],$all);
        return back()->with('message', 'Slider Added Successfully!');
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $slider  = Slider::find($id);
        return view('backend.slider.edit',compact('slider'));

    }

    public function update(SliderUpdateRequest $request,Slider $slider)
    {
       $all = $request->all();
       $all['status'] = $request->status ? true : false;
       if ($request->hasFile('image')) {
            $all['image'] = $this->updateImage($slider->image, $request->image, "sliders", "slider", true);
       }
        $all = $slider->update($all);
        return back()->with('message', 'Slider Update Successfully!');
    }


    public function destroy(Slider $slider)
    {
         $slider->delete();
        return back()->with('message', 'Slider Deleted Successfully!');
    }
}
