<?php

namespace App\Providers;

use App\Models\Size;
use App\Models\Region;
use App\Models\Category;
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
        View::share('categories',Category::orderBy('name', 'asc')->get());
        View::share('regions',Region::orderBy('name', 'asc')->get());
        View::share('sizes',Size::get());

    }
}
