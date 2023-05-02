<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\PointRedeem;
use App\PointTransaction;
use App\SiteConfig;
use App\UserPoint;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class RedeemController extends Controller
{

    public function index()
    {
        $agent = new Agent();
        $point = UserPoint::where('user_id',auth()->id())->firstOrFail();
        $redeems = PointRedeem::where('user_id',auth()->id())->latest()->get();
        return view(
            $agent->isMobile() ? 'mobile.pages.point' : 'frontend.pages.point',
            compact('point','redeems')
        );
    }

    public function redeemPoint(Request $request)
    {
        $this->validate($request,[
            'point' => 'required|numeric'
        ]);
        $userId = auth()->id();
        $point = UserPoint::where('user_id',auth()->id())->firstOrFail();
        if($request->point <= $point->amount){
            try{
                DB::beginTransaction();
                $config = SiteConfig::first();
                // generate transaction
                PointTransaction::create([
                    'user_id' => $userId,
                    'amount' => $request->point,
                    'previous_amount' => $point->amount,
                    'status' => 'approved',
                    'type' => 'point-redeem',
                    'note' => null
                ]);
                // substract points from user point
                $point->amount -= $request->point;
                $point->update();
                // create redeem
                PointRedeem::create([
                    'user_id' => $userId,
                    'code' => "rdm-".$this->generateRandomString(6),
                    'valid_till' => now()->addDays(30),
                    'value' => floor($request->point / $config->point_unit),
                    'status' => 'Pending',
                ]);
                DB::commit();
            }catch(Exception $e){
                DB::rollBack();
                dd($e);
                return redirect()->back();
            }
            
        }else{
            return redirect()->back()->withInput($request->all())->withErrors(['point' => 'Amount is Not Valid']);
        }
        return redirect()->back();
    }

    static function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
