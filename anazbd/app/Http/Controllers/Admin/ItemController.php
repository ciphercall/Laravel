<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SubCategory;
use App\Models\Wishlist;
use App\SearchHistory;
use App\Seller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function history($id)
    {
        $data['item'] = Item::with('tags')->findOrFail($id);
        $data['searchedTags'] = SearchHistory::whereIn('search',$data['item']->tags->pluck('name'))
        ->select('search', DB::raw('count(*) as total'))
        ->groupBy('search')->get();
        $data['interested_users'] = SearchHistory::with('user:id,name')->whereIn('search',$data['item']->tags->pluck('name'))->get(['id','user_id']);
        $data['wishlisted'] = Wishlist::where('item_id',$id)->count();
        $data['orders'] = Order::with('items:id,order_id,item_id,subtotal','user:id,name')->latest()->whereHas('items',function($q)use($id){
            $q->where('item_id',$id);
        })->get(['id','user_id','status','no','total']);
        $data['total_sold'] = OrderItem::whereIn('order_id',$data['orders']->pluck('id'))->where('item_id',$id)->sum('subtotal');
        return view('admin.items.history',compact('data'));
    }
    public function import(Request $request)
    {
        $this->validate($request,[
            'file' => 'required|mimes:csv,txt'
        ],[
            'file.mimes' => 'The File Must Be a CSV file aka Excel file.'
        ]);
        $data = $this->csvToArray($request->file);
        // dd($data);
        foreach($data as $item){
            $product = Item::with('variants')
            ->withCount('variants')
            ->where('slug',$item['slug'] ?? '')
            ->first();
            if($product != null && $product->variants != null && $product->variants_count == 1){
                $variant = $product->variants->first();
                $variant->sale_price = $item['Sale Price'];
                $variant->price = $item['Price'];
                $variant->sale_start_day = Carbon::parse($item['Sale Starts At']);
                $variant->sale_end_day = Carbon::parse($item['Sale Ends At']);
                $variant->update();
            }
        }
        return redirect(url()->previous());
    }
    public function export(Request $request)
    {
        $categories = Category::get(['id','name']);
        $subcategories = [];
        $childCategories = [];
        $brands = Brand::get(['id','name']);
        $sellers = Seller::get(['id','shop_name']);

        if($request->has('download')){
            $fileName = 'Items.csv';
            $items = Item::with('seller:id,shop_name','brand:id,name','category:id,name','sub_category:id,name','child_category:id,name')
            ->when($request->type,function ($q) use($request){
                $q->where('status',$request->type == 1 ? true : false);
            })
            ->when($request->category_id,function ($q) use($request){
                $q->where('category_id',$request->category_id);
            })
            ->when($request->sub_category_id,function ($q) use($request){
                $q->where('sub_category_id',$request->sub_category_id);
            })
            ->when($request->brand_id,function ($q) use($request){
                $q->where('brand_id',$request->brand_id);
            })
            ->when($request->child_category_id,function ($q) use($request){
                $q->where('child_category_id',$request->child_category_id);
            })
            ->when($request->seller_id,function ($q) use($request){
                $q->where('seller_id',$request->seller_id);
            })
            ->when($request->name,function ($q) use($request){
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->where('status',true)
            ->latest()->get();

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0",
                // "Content-Encoding"     => "UTF-8",
            );

            $columns = array('SL', 'Name','slug', 'Brand', 'Category', 'Sub Category','Child Category','Seller','Sale Price','Price','Sale Starts At','Sale Ends At');

            $callback = function() use($items, $columns) {
                $file = fopen('php://output', 'w');
                fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) )); // For Unicode characters
                fputcsv($file, $columns);

                foreach ($items as $index => $task) {
                    $row['sl']  = $index + 1;
                    $row['Name']    = $task->name;
                    $row['slug']    = $task->slug;
                    $row['Brand']    = $task->brand->name;
                    $row['Category']  = $task->category->name;
                    $row['sc']  = $task->sub_category->name ?? '';
                    $row['cc']  = $task->child_category->name ?? '';
                    $row['Seller']  = $task->seller->shop_name;
                    $row['Sale Price']  = $task->sale_amount;
                    $row['Price']  = $task->original_price;
                    $row['Sale Starts At']  = $task->sale_start_day;
                    $row['Sale Ends At']  = $task->sale_end_day;

                    fputcsv($file, array(
                        $row['sl'],
                        $row['Name'],
                        $row['slug'],
                        $row['Brand'],
                        $row['Category'],
                        $row['sc'],
                        $row['cc'],
                        $row['Seller'],
                        $row['Sale Price'],
                        $row['Price'],
                        $row['Sale Starts At'],
                        $row['Sale Ends At']
                    ));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
        $items = Item::with('seller:id,shop_name','brand:id,name','category:id,name','sub_category:id,name','child_category:id,name')
            ->when($request->type,function ($q) use($request){
                $q->where('status',$request->type == 1 ? true : false);
            })
            ->when($request->category_id,function ($q) use($request){
                $q->where('category_id',$request->category_id);
            })
            ->when($request->sub_category_id,function ($q) use($request){
                $q->where('sub_category_id',$request->sub_category_id);
            })
            ->when($request->brand_id,function ($q) use($request){
                $q->where('brand_id',$request->brand_id);
            })
            ->when($request->child_category_id,function ($q) use($request){
                $q->where('child_category_id',$request->child_category_id);
            })
            ->when($request->seller_id,function ($q) use($request){
                $q->where('seller_id',$request->seller_id);
            })
            ->when($request->name,function ($q) use($request){
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->where('status',true)
            ->latest()->paginate(20)
            ->appends([
                'status' => request('type'),
                'category_id'=>request('category_id'),
                'sub_category_id'=>request('sub_category_id'),
                'child_category_id' => request('child_category_id'),
                'name' => request('name'),
                'brand_id' => request('brand_id'),
                'seller_id'=>request('seller_id')]);;
        return view('admin.items.export',compact('brands','items','categories','subcategories','childCategories','sellers'));
    }

    function index(Request $request){
        $categories = Category::get(['id','name']);
        $subcategories = [];
        $childCategories = [];
        $sellers = Seller::get(['id','shop_name']);
        
        $items = Item::with('seller:id,shop_name','category:id,name','sub_category:id,name','child_category:id,name')
            ->when($request->type,function ($q) use($request){
                $q->where('status',$request->type == 1 ? true : false);
            })
            ->when($request->category_id,function ($q) use($request){
                $q->where('category_id',$request->category_id);
            })
            ->when($request->sub_category_id,function ($q) use($request){
                $q->where('sub_category_id',$request->sub_category_id);
            })
            ->when($request->child_category_id,function ($q) use($request){
                $q->where('child_category_id',$request->child_category_id);
            })
            ->when($request->seller_id,function ($q) use($request){
                $q->where('seller_id',$request->seller_id);
            })
            ->when($request->name,function ($q) use($request){
                $q->where('name', 'LIKE', '%' . $request->name . '%');
            })
            ->withTrashed()
            ->latest()->paginate(20)
            ->appends([
                'status' => request('type'),
                'category_id'=>request('category_id'),
                'sub_category_id'=>request('sub_category_id'),
                'child_category_id' => request('child_category_id'),
                'name' => request('name'),
                'seller_id'=>request('seller_id')]);;
        return view('admin.items.index',compact('items','categories','subcategories','childCategories','sellers'));
    }

    function changeDeliveryType(Item $item){
        $item->is_online_pay_only = !$item->is_online_pay_only;
        $item->update();
        Session::flush('success','Item Status Updated.');
        return redirect()->back();
    }
    function status(Item $item){
        $item->status = !$item->status;
        $item->update();
        Session::flush('success','Item Status Updated.');
        return redirect()->back();
    }

    public function destory(Item $item){
        $item->delete();
        Session::flush('success','Item Deleted.');
        return redirect()->back();
    }

    function restore($id){
        $item = Item::withTrashed()->find($id);
        $item->restore();
        Session::flush('success','Item Restored.');
        return redirect()->back();

    }

    private function csvToArray($filename = '', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
        {
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    return $data;
}
}
