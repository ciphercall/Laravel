<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Item;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function getCollectionProducts($slug)
    {
        $collection = Collection::where('slug',$slug)->first();
        $items = Item::where('collection_id',$collection->id)->where('status',true)->latest()->paginate(20);

        return response()->json([
            'status'  => 'success',
            'message' => "Items of $slug Loaded",
            'data'    => $items
        ]);
    }
}
