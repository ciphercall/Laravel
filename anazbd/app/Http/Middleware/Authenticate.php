<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->segment(1) == 'anaz' && $request->segment(2) == 'superAdmin') {
                return route('backend.login.form');
            } else if ($request->segment(1) == 'admin') {
                return route('admin.login.form');
            } else if ($request->segment(1) == 'seller') {
                return route('seller.login.form');
            } else if($request->segment(1) == 'delivery'){
                return route('delivery.login.form');
            }
            return route('frontend.user.login.form');
        }
    }
}
