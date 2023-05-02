<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class EmailConfigController extends Controller
{

    public function index(Request $request)
    {
        $config = EmailConfig::find(1);

        return view('backend.sms & email.email-config', compact('config'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'host' => 'required',
            'port' => 'required|numeric',
            'display_name' => 'required|min:3',
            'display_email' => 'required|email',
        ]);

        try {
            EmailConfig::updateOrCreate(['id' => 1], [
                'username' => $request->username,
                'password' => $request->password,
                'host' => $request->host,
                'port' => $request->port,
                'display_name' => $request->display_name,
                'display_email' => $request->display_email,
            ]);

            Artisan::call('config:clear');

            return back()->with('message', 'Config updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'An unknown error occurred!');
        }
    }
}
