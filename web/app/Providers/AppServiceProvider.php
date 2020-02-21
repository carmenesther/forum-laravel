<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // if we want do it with only a single view to share a variable

//        \View::composer('threads.create', function($view)
//        {
//            $view->with('channels', \App\Channel::all());
//        });

        // if we want to share this variable with all of them
          View::share('channels', \App\Channel::all());
    }
}
