<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlashSale\StoreRequest;
use App\Http\Requests\FlashSale\UpdateRequest;
use App\Models\FlashSale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flash_sales = FlashSale::paginate(24);

        return view('backend.flash_sales.index', compact('flash_sales'));
    }

    public function create()
    {
        return view('backend.flash_sales.create');
    }

    public function store(StoreRequest $request)
    {
        FlashSale::create([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'min_percentage' => $request->min_percentage,
            'max_items_per_seller' => $request->max_items_per_seller,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.campaign.flash_sale.index')->with('message', 'Flash sale created successfully');
    }

    public function edit($id)
    {
        $sale = FlashSale::find($id);

        return view('backend.flash_sales.edit', compact('sale'));
    }

    public function update(UpdateRequest $request, $id)
    {
        FlashSale::where('id', $id)
            ->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'min_percentage' => $request->min_percentage,
                'max_items_per_seller' => $request->max_items_per_seller,
                'status' => $request->status,
            ]);

        return redirect()->route('backend.campaign.flash_sale.index')->with('message', 'Flash sale updated successfully');
    }

    public function destroy($id)
    {
        try {
            FlashSale::where('id', $id)->delete();
        } catch (\Exception $e) {
            return redirect()->route('backend.campaign.flash_sale.index')->with('error', 'Flash sale is already used!');
        }

        return redirect()->route('backend.campaign.flash_sale.index')->with('message', 'Flash sale deleted successfully');
    }
}
