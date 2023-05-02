<?php

namespace App\Providers;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($user, $ability) {
            if ($user->is_super) {
                return true;
            }
        });
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    $key = "permission_.$user->email._.$permission->name";
                    return cache()->remember($key,Carbon::now()->addDays(30),function() use($user,$permission){
                        return $user->hasPermissionTo($permission);
                    });
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }

        //Blade directives
        Blade::if('role',function($roles){
            if (auth('admin')->user() && auth('admin')->user()->hasAnyRole($roles)){
                return true;
            }
            return false;
        });
    }
}
