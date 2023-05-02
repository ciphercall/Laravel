<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    function index(){
        $collections = Collection::withCount('items')->where('status',true)->latest()->paginate(15);
        return view('seller.collection.index',compact('collections'));
    }

    function create($id){
        $collection = Collection::find(az_unhash($id));
        $items = DB::table((new Item)->getTable())->where('status',true)->where('seller_id',auth('seller')->id())->where('collection_id','!=',$collection->id)->get(['id','name']);
        return view('seller.collection.create',compact('collection','items'));
    }

    function store(Request $request,Collection $collection){
        $this->validate($request,[
            'item_id.*' => 'required|numeric'
        ],[
            'item_id.*.required' => 'Items are required',
            'item_id.*.numeric' => 'Items must be a number'
        ]);
        Item::whereIn('id',$request->item_id)->where('seller_id',auth('seller')->id())->update([
            'collection_id' => $collection->id
        ]);

        return redirect()->route('seller.product.collection.index');
    }

    function edit($id){
        $collection = Collection::findOrFail(az_unhash($id));
        $collection->load(['items' => function($q){
            $q->where('seller_id',auth('seller')->id())->get();
        }]);

        $items = DB::table((new Item)->getTable())->where('status',true)->where('seller_id',auth('seller')->id())->get(['id','name']);
        return view('seller.collection.edit',compact('collection','items'));
    }

    function update(Request $request,Collection $collection){
        $this->validate($request,[
            'item_id.*' => 'required|numeric'
        ],[
            'item_id.*.required' => 'Items are required',
            'item_id.*.numeric' => 'Items must be a number'
        ]);
        Item::where('seller_id',auth('seller')->id())->where('collection_id',$collection->id)->update([
            'collection_id' => null
        ]);
        Item::whereIn('id',$request->item_id ?? [])->where('seller_id',auth('seller')->id())->update([
            'collection_id' => $collection->id
        ]);
        return redirect()->back();
    }

}
