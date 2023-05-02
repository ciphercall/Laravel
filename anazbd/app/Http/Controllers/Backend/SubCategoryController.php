<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subcategories\StoreRequest;
use App\Http\Requests\Subcategories\UpdateRequest;
use App\Traits\ImageOperations;
use NabilAnam\SimpleUpload\SimpleUpload;

class SubCategoryController extends Controller
{
    use ImageOperations;
    public function index()
    {
        $categories = SubCategory::with('category')->latest()->paginate(20);
        $parentCats = Category::get(['id','name']);
        return view('admin.subcategory.index', compact('categories','parentCats'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('backend.sub_categories.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {

//        $data           = $request->all();
//        $data['image']  = (New SimpleUpload)->file($request->image)
//                        ->dirName('subCategories')
//                        ->save();
//
//        SubCategory::create($data);

        $all = $request->all();
        if($request->has('image')){
            if($request->has('id')){
                $all['image'] = $this->updateImage(SubCategory::findOrFail($request->id)->image,$request->image,"subCategories","sub_category");
            }else{
                $all['image'] = $this->saveImage("subCategories",$request->image,"sub_category");
            }
        }
        SubCategory::updateOrCreate(['id' => $request->id],$all);


        return redirect()
            ->route('backend.product.sub_categories.index')
            ->with('message', 'Subcategory created successfully!');
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        // dd($categories);

        return view('backend.sub_categories.edit', compact('categories', 'subCategory'));
    }

    public function update(UpdateRequest $request, SubCategory $subCategory)
    {

//        $all          = $request->all();
//        $all['image'] = (new SimpleUpload)->file($request->image)
//            ->dirName('subCategories')
//            ->deleteIfExists($subCategory->image)
//            ->save();
//
//        $subCategory->update($all);
        $all = $request->all();
        if($request->has('image')){
            $all['image'] = $this->saveImage("subCategories",$request->image,"sub_category");
        }
        $subCategory->update($all);


        return redirect()
            ->route('backend.product.sub_categories.index')
            ->with('message', 'Subcategory updated successfully!');
    }

    public function destroy(SubCategory $subCategory)
    {
        try {
            $subCategory->delete();
        } catch (\Exception $e){
            return redirect()
                ->route('backend.product.sub_categories.index')
                ->with('error', 'Subcategory is referenced in another place!');
        }

        return redirect()
            ->route('backend.product.sub_categories.index')
            ->with('message', 'Subcategory deleted successfully!');
    }
     // ajax
    public function ajaxGetSubCategories($category_id)
    {
        return SubCategory::where('category_id', $category_id)->get(['id', 'name']);
    }
}
