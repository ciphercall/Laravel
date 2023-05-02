<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Item;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    public function index()
    {
        $sales = FlashSaleItem::whereAuthSeller()
            ->selectRaw('COUNT(id) as count, id, start_time, end_time, percentage, created_at')
            ->groupBy('start_time')
            ->orderByDesc('start_time')
            ->paginate(10);

        return view('seller.flash_sales.index', compact('sales'));
    }

    public function create()
    {
        $items = Item::whereAuthSeller()->get(['id', 'name']);
        $sales = FlashSale::where('status', 1)->get();

        return view('seller.flash_sales.create', compact('items', 'sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'date_till' => 'required|date_format:Y-m-d|after_or_equal:date',
            'time' => 'required|numeric',

            'item.*' => 'required|numeric',
//            'qty.*' => 'required|numeric',
            'percentage.*' => 'required|numeric',
        ]);

        $sale = FlashSale::find($request->time);
        $reqItemCount = count($request->s_item ?? []) + count($request->item ?? []);
        if ($reqItemCount > $sale->max_items_per_seller) {
            return back()->with('error', 'Seller max items exceeded!');
        }
        $start_time = Carbon::createFromFormat('h:i a', $sale->start_time);
        $end_time = Carbon::createFromFormat('h:i a', $sale->end_time);

        foreach ($request->item as $key => $item_id) {
            FlashSaleItem::updateOrCreate([
                'item_id' => $item_id,
                'seller_id' => auth('seller')->id(),
                'start_time' => Carbon::parse($request->date)->setTimeFrom($start_time),
                'end_time' => Carbon::parse($request->date_till)->setTimeFrom($end_time),
            ], [
                'flash_sale_id' => $request->time,
//                'stock' => $request->qty[$key],
                'percentage' => $request->percentage[$key],
            ]);
        }

        return redirect()->route('seller.campaign.flash_sale.index')->with('message', 'Flash Sale created successfully!');
    }

    public function edit($start_time)
    {
        $items = Item::whereAuthSeller()->get(['id', 'name']);
        $sales = FlashSale::where('status', 1)->get();
        $sale_items = FlashSaleItem::whereAuthSeller()->where('start_time', $start_time)->get();

        return view('seller.flash_sales.edit', compact('items', 'sales', 'sale_items'));
    }

    public function update(Request $request, $start_time)
    {
        $request->validate([
            'date'      => 'required|date_format:Y-m-d',
            'time'      => 'required|numeric',
            'date_till' => 'required|date_format:Y-m-d|after_or_equal:date',
            's_item.*'  => 'required|numeric',
//            's_qty.*' => 'required|numeric',
            's_percentage.*' => 'required|numeric',

            'item.*' => 'required|numeric',
//            'qty.*' => 'required|numeric',
            'percentage.*' => 'required|numeric',
        ]);

        try {
            $sale = FlashSale::find($request->time);
            $reqItemCount = count($request->s_item ?? []) + count($request->item ?? []);
            if ($reqItemCount > $sale->max_items_per_seller) {
                return back()->with('error', 'Seller max items exceeded!');
            }
            // $start_time = Carbon::createFromFormat('h:i a', $sale->start_time);
            $end_time = Carbon::createFromFormat('h:i a', $sale->end_time);
            $variants = collect(Variant::whereIn('item_id', $request->s_item)->get())->unique('item_id');

            DB::beginTransaction();
            FlashSaleItem::whereAuthSeller()->where('start_time', $start_time)->whereNotIn('id', array_keys($request->s_item))->delete();

            foreach ($request->s_item ?? [] as $key => $item_id) {
                $curPrice = $variants->where('item_id', $item_id)->first()->price;
                $salePrice = round($curPrice - ($curPrice * ($request->s_percentage[$key] / 100)));
                FlashSaleItem::updateOrCreate([
                    'id' => $key,
                    'item_id' => $item_id,
                    'seller_id' => auth('seller')->id(),
                ], [
                    'start_time' => Carbon::parse($request->date)->setTimeFrom($start_time),
                    'end_time' => Carbon::parse($request->date_till)->setTimeFrom($end_time),
                    'flash_sale_id' => $request->time,
//                    'stock' => $request->s_qty[$key],
                    'percentage' => $request->s_percentage[$key],
                    'sale_price' => $salePrice,
                ]);
            }

            foreach ($request->item ?? [] as $key => $item_id) {
                FlashSaleItem::updateOrCreate([
                    'item_id' => $item_id,
                    'seller_id' => auth('seller')->id(),
                    'start_time' => Carbon::parse($request->date)->setTimeFrom($start_time),
                    'end_time' => Carbon::parse($request->date)->setTimeFrom($end_time),
                ], [
                    'flash_sale_id' => $request->time,
//                    'stock' => $request->qty[$key],
                    'percentage' => $request->percentage[$key],
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('seller.campaign.flash_sale.index')->with('message', 'Flash Sale already used!');
        }

        return redirect()->route('seller.campaign.flash_sale.index')->with('message', 'Flash Sale updated successfully!');
    }

    public function destroy($start_time)
    {
        try {
            FlashSaleItem::whereAuthSeller()->where('start_time', $start_time)->delete();
        } catch (\Exception $e) {
            return redirect()->route('seller.campaign.flash_sale.index')->with('message', 'Flash Sale is already used!');
        }
        return redirect()->route('seller.campaign.flash_sale.index')->with('message', 'Flash Sale deleted successfully!');
    }

    public function ajaxCount($date, $time)
    {
        return response()->json([
            'count' => FlashSaleItem::whereAuthSeller()
                ->where('start_time', Carbon::parse($date)->setTimeFrom(FlashSale::find($time)->start_time))
                ->count()
        ]);
    }
}
