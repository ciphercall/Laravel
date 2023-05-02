<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Blog;
class BlogController extends Controller
{
    public function index()
    {
    	$blog 	= Blog::where('top',1)->with('admin')->first();
        $related_blogs 	= Blog::where('id','!=',$blog->id??-1)->limit(3)->inRandomOrder()->get();
        // dd($related_blogs);
    	return view('frontend.pages.blog',['blog' => $blog, 'related_blogs' => $related_blogs]);
    }

    public function show($slug)
    {
    	$blog = Blog::where('slug',$slug)->first();
        $blogs  = Blog::where('id','!=',$blog->id??-1)->limit(3)->inRandomOrder()->get();
        return view('frontend.pages.blog',['blog' => $blog, 'related_blogs' => $blogs]);
    }
}
