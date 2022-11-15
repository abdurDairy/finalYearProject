<?php

namespace App\Providers;

use App\Models\navigation;
use App\Models\teacherInfo;
use Illuminate\Routing\ViewController;
use Illuminate\Support\Composer;
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
        //
        view()->composer('index', function ($view) {
            $view->with('navData',navigation::latest()->first());
        });

    }
}