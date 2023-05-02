<?php

namespace App\Http\Middleware;

use Closure;

class NewAdminMiddleware
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
//        if (Auth::guard('admin')->check()) {
//            return $next($request);
//        }
//        return redirect()->route('backend.login.form');

        session()->put('isAdmin', true);
        return $next($request);

    }
}
