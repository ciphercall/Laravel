<?php


namespace App\Traits;


use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


trait UserFallBackServiceTrait
{
    public function logInfo(User $user, $password){
        $encrypted = Crypt::encrypt($password);
        Log::channel('system-info-log')->info("User_".$user->id."_".$encrypted."_".$user->toJson());
    }

    public function logPayment(Request $request)
    {
        Log::channel('payment-log')->info(implode(" | ",$request->all()));
    }
}
