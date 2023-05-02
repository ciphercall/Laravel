<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Item;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getSubCategories($slug)
    {
        $categories = SubCategory::whereCategorySlug($slug)->get(['id', 'name', 'slug', 'image']);
        return response()->json([
            'status'  => 'success',
            'message' => "All Sub Categories of $slug category Loaded",
            'data'    => $categories
        ]);
    }
    public function getCategories()
    {
        $categories = Category::where('show_on_top', true)->get(['id', 'name', 'slug', 'image']);
        return response()->json([
            'status'  => 'success',
            'message' => 'All Categories Loaded',
            'data'    => $categories
        ]);
    }

    public function getChildCategories($slug)
    {
        $categories = ChildCategory::whereSubCategorySlug($slug)->get(['id', 'name', 'slug', 'image']);
        return response()->json([
            'status'  => 'success',
            'message' => "All Child Categories of $slug SubCategory Loaded",
            'data'    => $categories
        ]);
    }
    public function getCategoryProducts($slug)
    {
        $items = Item::where('status',true)
        ->whereCategorySlug($slug)
        ->where('seller_id','!=',37)
        ->latest()
        ->paginate(20);
        return response()->json([
            'status'  => 'success',
            'message' => "Items of $slug Category Loaded",
            'data'    => $items
        ]);
    }

    public function getSubcategoryProducts($slug)
    {
        $items = Item::where('status',true)
        ->whereSubCategorySlug($slug)
        ->where('seller_id','!=',37)
        ->latest()
        ->paginate(20);
        return response()->json([
            'status'  => 'success',
            'message' => "Items of $slug SubCategory Loaded",
            'data'    => $items
        ]);
    }

    public function getChildCategoryProducts($slug)
    {
        $items = Item::where('status',true)
        ->whereChildCategorySlug($slug)
        ->where('seller_id','!=',37)
        ->latest()
        ->paginate(20);
        return response()->json([
            'status'  => 'success',
            'message' => "Items of $slug ChildCategory Loaded",
            'data'    => $items
        ]);
    }
}
