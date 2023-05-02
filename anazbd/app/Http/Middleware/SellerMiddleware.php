<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::guard('seller')->user()->status){
            Auth::logout();
            return redirect()->route('seller.login.form')->with('warning','Account Disabled. Contact at seller@anazbd.com.');
        }
        if (Auth::guard('seller')->check()){
            
            return $next($request);
        }
        return redirect()->route('seller.login.form');
    }
}
