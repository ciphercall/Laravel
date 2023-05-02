<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SMSConfig;
use Illuminate\Http\Request;

class SMSConfigController extends Controller
{
    public function index(Request $request)
    {
        $config = SMSConfig::first();

        return view('backend.sms & email.sms-config', compact('config'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'sender_id' => 'required'
        ]);

        try {
            SMSConfig::updateOrCreate(['id' => $id], [
                'username' => $request->username,
                'password' => $request->password,
                'sender_id' => $request->sender_id
            ]);

            return back()->with('message', 'Config updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'An unknown error occurred!');
        }
    }
}
