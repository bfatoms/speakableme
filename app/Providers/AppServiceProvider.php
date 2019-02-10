<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\EntityObserver;
use App\Models\Entity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
