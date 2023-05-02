<?php

namespace App\Http\Controllers\Admin;

use App\DeliveredNotifyReceiver;
use App\Http\Controllers\Controller;
use App\PointChart;
use App\SiteConfig;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $config = SiteConfig::first();
        $subscribers = DeliveredNotifyReceiver::paginate(15);
        $pointCharts = PointChart::latest()->get();
        return view('admin.site-settings.index',compact('config','subscribers','pointCharts'));
    }

    public function store(Request $request)
    {        
        $cashbackEnabled = false;
        if($request->has('is_cashback_enabled') && $request->is_cashback_enabled == "true"){
            $cashbackEnabled = true;
        }
        SiteConfig::updateOrCreate([
            'id' => $request->id,
        ],[
            'is_cashback_enabled' => $cashbackEnabled,
            'cashback_amount' => $request->cashback_amount,
            'is_cod_enabled' => $request->has('is_cod_enabled') ? true : false,
            'is_point_reward_enabled' => $request->has('is_point_reward_enabled') ? true : false,
            'point_unit' => $request->point_unit
        ]);
        return redirect()->back();
    }

    public function storePoint(Request $request)
    {
        $this->validate($request,[
            'amount' => ['required','numeric'],
            'point' => ['required','numeric']
        ]);
        PointChart::create($request->all());
        return redirect()->back();
    }

    public function deletePoint($id)
    {
        PointChart::findOrFail($id)->delete();
        return redirect()->back();
    }
}
