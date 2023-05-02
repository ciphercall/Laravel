<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChildCategories\StoreRequest;
use App\Http\Requests\ChildCategories\UpdateRequest;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Traits\ImageOperations;
use Illuminate\Http\Request;
use NabilAnam\SimpleUpload\SimpleUpload;

class ChildCategoryController extends Controller
{
    use ImageOperations;

    public function index()
    {
        $categories = ChildCategory::with('sub_category.category')->latest()->paginate(25);
        $parentCats = Category::get(['id','name']);
        return view('admin.childCategory.index', compact('categories','parentCats'));
    }

    public function create()
    {
        $categories = Category::get(['id', 'name']);

        return view('backend.child_categories.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $all = $request->all();
        if($request->hasFile('image')){
            if($request->has('id')){
                $all['image'] = $this->updateImage(ChildCategory::findOrFail($request->id)->image,$request->image,"childCategories","child_category");
            }else{
                $all['image'] = $this->saveImage("childCategories",$request->image,"child_category");
            }
        }
        ChildCategory::updateOrCreate(['id' => $request->id],$all);


        return redirect()
            ->route('backend.product.child_categories.index')
            ->with('message', 'Child Category created successfully!');
    }

    public function edit($id)
    {
        $childCategory  = ChildCategory::with('category.sub_categories')->find($id);
        $categories     = Category::get(['id', 'name']);
        // $categories     = category::

        return view('backend.child_categories.edit', compact('childCategory', 'categories'));
    }

    public function update(UpdateRequest $request, ChildCategory $childCategory)
    {

//        $all          = $request->all();
//        $all['image'] = (new SimpleUpload)
//                    ->file($request->image)
//                    ->dirName('childCategories')
////                    ->resizeImage(1140,290)
//                    ->deleteIfExists($childCategory->image)
//                    ->save();
//        $childCategory->update($all);

        $all = $request->all();
        if($request->has('image')){
            $all['image'] = $this->saveImage("childCategories",$request->image,"child_category");
        }
        $childCategory->update($all);


        return redirect()
            ->route('backend.product.child_categories.index')
            ->with('message', 'Child Category updated successfully!');
    }

    public function destroy($id)
    {
        try {
            ChildCategory::where('id', $id)->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('backend.product.child_categories.index')
                ->with('error', 'Child Category is referenced in another place!');
        }

        return redirect()
            ->route('backend.product.child_categories.index')
            ->with('message', 'Child Category deleted successfully!');
    }

    // ajax

    public function ajaxGetChildCategories($subcategory_id)
    {
        return ChildCategory::where('subcategory_id', $subcategory_id)->get(['id', 'name']);
    }
}
