<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Channel;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $allchannels = Channel::orderBy('id', 'DESC')->get();
        return View::share('allchannels',$allchannels);
    }
}
