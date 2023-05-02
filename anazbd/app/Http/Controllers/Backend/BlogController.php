<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Blog;
use App\Traits\ImageOperations;
use NabilAnam\SimpleUpload\SimpleUpload;

class BlogController extends Controller
{
	use ImageOperations;

    public function index($value='')
    {
        return view('admin.blog.index',['blogs' => Blog::latest()->paginate(18)]);
    }

    public function create()
    {

        return view('admin.blog.create');
    }

    public function store(Request $request, SimpleUpload  $upload)
    {
    	$data 				= $request->all();
    	// $data['slug'] 		= $request->title;
        $data['top']        = $request->top == 'on';
    	$data['admin_id'] 	= Auth('admin')->id();
    	$data['large_image'] = $this->saveImage("blogs",$this->resize($request->image,1162,700),'blog-large',false,"other");
        $data['short_image'] = $this->saveImage("blogs",$this->resize($request->image,370,270),'blog-short',false,"other");
      	Blog::create($data);

      	return redirect()->route('backend.blog.index')->with('message', 'Blog Added Successfully!');

    }



     public function edit(Blog $blog)
    {
        // dd($blog);
        return view('admin.blog.edit',compact('blog'));

    }

    public function update(Request $request, SimpleUpload  $upload, Blog $blog)
    {

    	$data 				= $request->all();
        // $data['slug']       = $request->title;
    	$data['top'] 		= $request->top == 'on';
    	$data['admin_id'] 	= Auth('admin')->id();

    	$data['large_image'] = $upload
            	->file($request->image)
            	->dirName('short_image')
            	->resizeImage(1162, 700)
            	->deleteIfExists($blog->large_image)
            	->save();

        $data['short_image'] = $upload
            	->file($request->imge)
           	    ->dirName('short_image')
            	->resizeImage(370, 270)
            	->deleteIfExists($blog->short_image)
            	->save();

      	// dd($blog, $data);
        $blog->update($data);

      	return redirect()->route('backend.blog.index')->with('message', 'Blog Updated Successfully!');

    }

    public function destroy(Blog $blog)
    {
    	$blog->delete();
    	return redirect()->route('backend.blog.index')->with('message', 'Blog Deleted Successfully!');
    }
}
