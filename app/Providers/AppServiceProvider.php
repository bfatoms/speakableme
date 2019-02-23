<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\EntityObserver;
use App\Models\Entity;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Entity::observe(EntityObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
