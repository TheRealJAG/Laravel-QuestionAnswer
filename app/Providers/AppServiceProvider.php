<?php

namespace App\Providers;

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
        // Bind the tags to the tag container
        // This way it's not necessary to pass in controllers.
        view()->composer('containers.tags', function ($view) {
            $view->with('tags', \App\Tag::get_tags());
        });
    }
}
