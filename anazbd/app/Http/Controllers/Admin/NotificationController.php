<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PushNotification;
use App\Traits\ImageOperations;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ImageOperations;
    public function index()
    {
        $notifications = PushNotification::with('admin')->latest()->paginate(20);
        return view('admin.notifications.index',compact('notifications'));
    }

    public function send(Request $request)
    {
        $this->validate($request,[
            'title' => ['required','string'],
            'body' => ['required','string'],
            'image' => ['nullable','mimes:jpg,png,jpeg,svg,webp']
        ]);
        $key = "AAAAGivtoiM:APA91bFse2Jq95yFayTvKnpRZT_R0Smh5r6t9XMydgRHmCc1dw1U8DMXWVtHYCVSCX5o1iHlbWmegLOP237U7Uq78iLFCfWNg4-1FULpeU-UylX13eaeD9ZaQI4wo_tyBpjPF8ItzsAI";
        $ids = User::whereNotNull('device_token')->get(['id','device_token']);
        
        $headers = [
            'Authorization: key=' . $key,
            'Content-Type: application/json',
            'sender_id:112406143523',
        ];

        $image = null;
        if($request->hasFile('image')){
            $image = $this->saveImage('notifications',$request->image,'notification');
        }
        PushNotification::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $image,
            'sent_to' => $ids->pluck('id')->implode(','),
            'admin_id' => auth('admin')->id()
        ]);
        $data = [
            "registration_ids" => $ids->pluck('device_token'),
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
                "image" => asset($image)
            ]
        ];

        $dataString = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        return redirect()->back();
    }
}
