<?php

namespace Mandark\Decoda;

use Illuminate\Support\ServiceProvider;

class LaravelDecodaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        // Publish config
        $this->publishes([
            __DIR__.'/config/preferences.php' => config_path('laravel-decoda.php'),
        ], 'config');

        // Publish public assets (emoticon-images as well as the WysiBB-JS).
        $this->publishes([
            __DIR__.'/public/' => public_path('vendor/mandark/laravel-decoda'),
        ], 'public');

        // Publish views
        $this->publishes([
            __DIR__.'/../../views/' => base_path('/resources/views/vendor/forum')
        ], 'views');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('decoda', function($app)
        {
            return $this->app->make(LaravelDecoda::class);
        });

        // Merge config
        $this->mergeConfigFrom(__DIR__.'/config/laravel-decoda.php', 'laravel-decoda');

    }
}
