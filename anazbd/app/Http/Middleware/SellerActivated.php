<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SellerActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('seller')->check() && Auth::guard('seller')->user()){
            if(Auth::guard('seller')->user()->status){
                return $next($request);
            }
            Auth::logout();
            return redirect()->route('seller.login.form')->with('message','Account Disabled. Contact at seller@anazbd.com.');
        }
        return $next($request);
    }
}
