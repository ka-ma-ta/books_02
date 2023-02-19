<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//ADD
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

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
        
        //ADD
        Schema::defaultStringLength(191);
        URL::forceScheme('https');
        
    }
}