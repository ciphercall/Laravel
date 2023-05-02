<?php

namespace App\Providers;

use App\Models\SiteInfo;
use App\Models\QuickPage;
use App\Models\Slider;
use App\Models\Banner;
use App\Models\Sociallink;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use DB;
Use File;
use Request;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Query Logging start
        // dd($_SERVER["REMOTE_ADDR"]);
            // DB::listen(function($query) {
            //     $path = 'logs/query_'.date('d-m-y');
            //     File::append(
            //         storage_path($path.'.log'),
            //         '[' . date('Y-m-d H:i:s') . ']' .PHP_EOL . $_SERVER["REMOTE_ADDR"] . PHP_EOL . $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL . PHP_EOL
            //     );
            // });
        // Query Logging End

        Schema::defaultStringLength(191);
        date_default_timezone_set('Asia/Dhaka');

        view()->composer('*', function ($view) {
            session()->forget('info');
            session()->forget('socialLinks');
            session()->forget('quickpages');

            if (!session()->exists('info')) {
                session()->put('info', cache()->remember('info',Carbon::now()->addDay(),function(){
                    return SiteInfo::find(1);
                }));
            }

            // if (Str::startsWith($view->getName(), 'frontend.')) {
                if (!session()->exists('quickpages')) {

                    session()->put('quickpages', cache()->remember('quickpages',Carbon::now()->addDay(),function(){
                        return QuickPage::all();
                    }));
                    // session()->put('socialLinks', Sociallink::first());
                }
                // cache()->forget('socialLinks');
                
                if (!session()->exists('socialLinks')) {

                    // session()->put('quickpages', QuickPage::all());
                    session()->put('socialLinks', cache()->remember('socialLinks',Carbon::now()->addDay(),function(){
                        return Sociallink::first();
                    }));
                    
                }
                
                if($view->getName() =='welcome' || $view->getName() =='mobile.index'){
                    session()->put('sliders', cache()->remember('sliders',Carbon::now()->addDay(),function(){
                        return Slider::orderBy('position')->where('status', true)->get(['image','slug']);
                    }));
                    session()->put('banner', cache()->remember('banner',Carbon::now()->addDay(),function(){
                        return Banner::where('status',true)->first();
                    }));
                };


                view()->share('quickpages', session()->get('quickpages'));
                view()->share('socialLinks', session()->get('socialLinks'));
                view()->share('sliders', session()->get('sliders'));
                view()->share('banner', session()->get('banner'));


            view()->share('info', session()->get('info'));

            if ($view->getName() == 'backend.partials._footer') {
                session()->forget('info');
            }
        });
    }
}
