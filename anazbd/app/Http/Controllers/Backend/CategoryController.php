<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreRequest;
use App\Http\Requests\Categories\UpdateRequest;
// use App\Models\Collection;
use Illuminate\Support\Collection;
use NabilAnam\SimpleUpload\SimpleUpload;
use App\Traits\ImageOperations;


class CategoryController extends Controller
{
    use ImageOperations;



    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.categories.create');
    }

    public function store(StoreRequest $request)
    {
//        $upload = new SimpleUpload;
//        $all = $request->all();
//        // dd($all);
//        $all['show_on_top'] = $request->show_on_top === 'on';
//        $all['image'] = $upload
//            ->file($request->image)
//            ->resizeImage(1140,290)
//            ->save();
//        $all['thumbnail_image'] = $upload
//            ->dirName('category_thumbs')
//            ->resizeImage(60, 60)
//            ->save();
//
//        Category::create($all);

        $all = $request->all();
        $all["show_on_top"] = $request->has('show_on_top') ? true : false;
        if($request->hasFile('image')){
            if($request->has('id')){
                $cat = Category::find($request->id);
                $all['image'] = $this->updateImage($cat->image,$request->image,"categories","category");
            }else{
                $all['image'] = $this->saveImage("categories",$request->image,"category");
            }
        }
        
        Category::updateOrCreate([
            'id' => $request->id
        ],$all);
        return redirect()
            ->route('backend.product.categories.index')
            ->with('message', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('backend.categories.edit', compact('category'));
    }

    public function update(UpdateRequest $request, Category $category)
    {
//        $upload = new SimpleUpload;
//        $all = $request->all();
//
//        $all['show_on_top'] = $request->show_on_top == 'on';
//        $all['image'] = $upload
//                ->file($request->image)
//                ->dirName('categories')
//                ->deleteIfExists($category->image)
//                ->save();
//        $all['thumbnail_image'] = $upload
//                ->dirName('category_thumbs')
//                ->resizeImage(60, 60)
//                ->deleteIfExists($category->thumbnail_image)
//                ->save();
        $all = $request->all();
        $all["show_on_top"] = $request->has('show_on_top') ? true : false;
        if($request->has('image')){
            $all['image'] = $this->saveImage("categories",$request->image,"category");
        }
        $category->update($all);



        return redirect()
            ->route('backend.product.categories.index')
            ->with('message', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (\Exception $e){
            return redirect()
                ->route('backend.product.categories.index')
                ->with('error', 'Category is referenced in another place!');
        }

        return redirect()
            ->route('backend.product.categories.index')
            ->with('message', 'Category deleted successfully!');
    }
}
