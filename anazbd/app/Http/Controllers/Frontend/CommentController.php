<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Mckenziearts\Notify\Facades\LaravelNotify;

class CommentController extends Controller
{

    public function index($id)
    {
        $data = Item::findorFail($id);
        return response()->json(['data' => $data]);
    }


    public function store(StoreRequest $request,$slug)
    {
        $data               = $request->all();
        $data   ['item_id'] = Item::where('slug',$slug)->first()->id;
        $data   ['user_id'] =  auth()->id('web');
        Comment::create($data);
        notify()->success('Thanks For Your Review.');
        return back();
    }



}
