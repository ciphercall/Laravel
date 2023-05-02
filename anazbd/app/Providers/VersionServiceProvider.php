<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VersionServiceProvider extends ServiceProvider
{
    public function register()
    {
        config()->set('version', 1.21);
    }
}