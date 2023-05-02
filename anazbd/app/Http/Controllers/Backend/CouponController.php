<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupons\StoreRequest;
use App\Http\Requests\Coupons\UpdateRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(12);

        return view('backend.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('backend.coupons.create');
    }

    public function store(StoreRequest $request)
    {
        $all = $request->all();
        $all['is_active'] = $request->is_active == 'on';

        Coupon::create($all);

        return redirect()
            ->route('backend.campaign.coupons.index')
            ->with('message', 'Coupon created successfully!');
    }

    public function edit(Coupon $coupon)
    {
        return view('backend.coupons.edit', compact('coupon'));
    }

    public function update(UpdateRequest $request, Coupon $coupon)
    {
        $all = $request->except('_token');
        $all['is_active'] = $request->is_active == 'on';

        $coupon->update($all);

        return redirect()
            ->route('backend.campaign.coupons.index')
            ->with('message', 'Coupon updated successfully!');
    }

    public function destroy($id)
    {
        try {
            Coupon::where('id', $id)->delete();
        } catch (\Exception $e) {
            return redirect()
                ->route('backend.campaign.coupons.index')
                ->with('error', 'Coupon is referenced in another place!');
        }

        return redirect()
            ->route('backend.campaign.coupons.index')
            ->with('message', 'Coupon deleted successfully!');
    }
}
