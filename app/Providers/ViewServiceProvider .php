<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Using class based composers...
        View::composer(
            '*', 'App\Http\ViewComposers\CategoryComposer'
        );
        View::composer(
            '*', 'App\Http\ViewComposers\RegionComposer'
        );
        View::composer(
            '*', 'App\Http\ViewComposers\AdTypeComposer'
        );
        View::composer(
            '*', 'App\Http\ViewComposers\StatisticsComposer'
        );
    }
}