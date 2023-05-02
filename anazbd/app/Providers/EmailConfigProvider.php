<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class EmailConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (Schema::hasTable('email_configs')) {
            $config = DB::table('email_configs')->first();

            if ($config) {
                Config::set('mail', [
                    'driver'    => 'smtp',
                    'host'      => $config->host,
                    'port'      => $config->port,
                    'from'      => [
                        'address' => $config->display_email,
                        'name' => $config->display_name,
                    ],
                    'encryption' => 'ssl',
                    'username' => $config->username,
                    'password' => $config->password,
                    'sendmail' => '/usr/sbin/sendmail -bs',
                    'markdown' => [
                        'theme' => 'default',
                        'paths' => [
                            resource_path('views/vendor/mail'),
                        ],
                    ],
                    'log_channel' => env('MAIL_LOG_CHANNEL'),
                ]);
            }
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
