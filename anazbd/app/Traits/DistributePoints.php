<?php

namespace App\Traits;

use App\Models\SiteInfo;
use App\PointChart;
use App\UserPoint;
use Illuminate\Support\Facades\DB;
use App\PointTransaction;
use App\SiteConfig;
use Exception;
use Illuminate\Support\Facades\Log;

trait DistributePoints{

    public function distributePoint($user,$order)
    {
        $config = SiteConfig::first();
        if($config->is_point_reward_enabled){
            $userId = $user->id;
            $total = $order->total;
            $pointChart = PointChart::where('amount','<=',(string)floor($total / 100) * 100)->latest()->first();
            if($pointChart != null && $pointChart->count() > 0){
                $point = $pointChart->point ?? 0;
                if($point > 0){
                    try{
                        DB::beginTransaction();
                        $userPoint = UserPoint::where('user_id',$userId)->first();
                        $previousPoint = $userPoint->point ?? 0;
                        // if($userPoint != null){
                        //     $userPoint->amount += $point;
                        //     $userPoint->update();
                        // }else{
                        //     UserPoint::create([
                        //         'user_id' => $userId,
                        //         'amount' => $point,
                        //     ]);
                        // }
                        PointTransaction::create([
                            'user_id' => $userId,
                            'amount' => $point,
                            'status' => 'pending',
                            'previous_amount' => $previousPoint,
                            'type' => "order-created-no-$order->no",
                        ]);
                        DB::commit();
                    }catch (Exception $e){
                        DB::rollBack();
                        Log::error($e->getMessage());
                    }
                }
            }
        }
    }

    public function approveTransaction($user,$order)
    {
        try{
            $userPoint = UserPoint::where('user_id',$user->id)->first();
            $pointTransaction = PointTransaction::where('user_id',$user->id)
            ->where('type',"order-created-no-$order->no")->first();
            if($userPoint != null){
                $userPoint->amount += $pointTransaction->amount;
                $userPoint->update();
            }else{
                UserPoint::create([
                    'user_id' => $user->id,
                    'amount' => $pointTransaction->amount,
                ]);
            }
            $pointTransaction->status = 'approved';
            $pointTransaction->update();
            return true;
        }catch(Exception $e){
            Log::error($e->getMessage());
            return false;
        }
        
    }
    public function cancelTransaction($user,$order)
    {
        try{
            $pointTransaction = PointTransaction::where('user_id',$user->id)
            ->where('type',"order-created-no-$order->no")->first();
            $pointTransaction->status = 'cancelled';
            $pointTransaction->update();
            return true;
        }catch(Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }
}
