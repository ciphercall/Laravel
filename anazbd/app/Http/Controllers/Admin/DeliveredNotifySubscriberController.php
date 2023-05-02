<?php

namespace App\Http\Controllers\Admin;

use App\DeliveredNotifyReceiver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DeliveredNotifySubscriberController extends Controller
{
    function store(Request $request){
        $this->validate($request,[
           'name' => 'required|string|min:5',
           'mobile' => 'required|numeric',
            'email' => 'nullable|email',
            'status' => 'nullable'
        ]);
        if (DeliveredNotifyReceiver::create($request->only('name','mobile','email','status'))){
            Session::flush('success','New Subscriber added.');
            return back();
        }
        Session::flush('error','Failed to add new subscriber.');
        return back();
    }

    function updateStatus($id){
        $subscriber = DeliveredNotifyReceiver::findOrFail($id);
        $subscriber->status = !$subscriber->status;
        $subscriber->update();
        return back();
    }


}
