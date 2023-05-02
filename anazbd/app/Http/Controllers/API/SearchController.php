<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchTags(Request $request)
    {
        $query = $request->get('query');
        $tags = Tag::where('name', 'LIKE', $query . '%')->whereHas('items')->limit(15)->get();
        return response()->json([
            'status'  => 'success',
            'message' => "Tags of Query $query Loaded",
            'data'    => $tags
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $items = Item::where('status', true)
            ->where('name', 'LIKE', '%' . $query . '%')
            ->orwhereHas('tags', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('variants', function ($q) use ($query) {
                $q->where('sku', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('origin', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('brand', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('sub_category', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->orwhereHas('child_category', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->where('seller_id','!=',37)
            ->paginate(18);

            $filtered = $items->reject(function ($item){
                return $item->seller_id == 37;
            });
            
            $obj = new \stdClass();
            $obj->total = $items->total();
            $obj->current_page = $items->currentPage();
            $obj->first_page_url = "1";
            $obj->next_page_url = $items->nextPageUrl();
            $obj->data = $filtered;

            return response()->json([
                'status'  => 'success',
                'message' => "Search results of Query $query Loaded",
                'data'    => $obj
            ]);

    }
}
