<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brands\StoreRequest;
use App\Http\Requests\Brands\UpdateRequest;
use App\Models\Brand;
use App\Traits\ImageOperations;
use Illuminate\Http\Request;
use NabilAnam\SimpleUpload\SimpleUpload;

class BrandController extends Controller
{
    use ImageOperations;
    public function index()
    {
        $brands = Brand::latest()->paginate(12);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('backend.brands.create');
    }

    public function store(StoreRequest $request)
    {
        $all = $request->all();
        if($request->hasFile('image')){
            if($request->has('id')){
                $brand = Brand::findOrFail($request->id);
                $all['image'] = $this->updateImage($brand->image,$request->image,"brands","brand");
            }else{
                $all['image'] = $this->saveImage("brands",$request->image,"brand");
            }
        }
        Brand::updateOrCreate(['id' => $request->id ],$all);
        return redirect()
            ->route('backend.product.brands.index')
            ->with('message', 'Brand created successfully!');
    }

    public function edit(Brand $brand)
    {
        return view('backend.brands.edit', compact('brand'));
    }

    public function update(UpdateRequest $request, Brand $brand)
    {
        $all = $request->all();
        $all['image'] = (new SimpleUpload)
            ->file($request->image)
            ->dirName('brands')
            ->deleteIfExists($brand->image)
            ->save();

        $brand->update($all);

        return redirect()
            ->route('backend.product.brands.index')
            ->with('message', 'Brand updated successfully!');
    }

    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
        } catch (\Exception $e){
            return redirect()
                ->route('backend.product.brands.index')
                ->with('error', 'Brand is referenced in another place!');
        }

        return redirect()
            ->route('backend.product.brands.index')
            ->with('message', 'Brand deleted successfully!');
    }
}
