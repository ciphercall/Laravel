<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\QuickPage;
class QuickPageController extends Controller
{
   public function index($slug)
   {
   		$page = QuickPage::where('slug',$slug)->first();
   		return view('frontend.pages.quickpage',compact('page'));
   }

   public function quickPageSD($slug){
       $shortDsc = QuickPage::select('short_desc')->where('slug',$slug)->first();
       return response()->json($shortDsc);
   }
}
