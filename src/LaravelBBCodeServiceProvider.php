<?php

namespace Mandark\BBCode;

use Illuminate\Support\ServiceProvider;

class LaravelBBCodeServiceProvider extends ServiceProvider
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
            __DIR__.'/config/bbcode.php' => config_path('bbcode.php'),
        ], 'config');

        // Publish public assets (emoticon-images as well as the WysiBB-JS).
        $this->publishes([
            __DIR__.'/public/' => public_path('vendor/mandark/bbcode'),
        ], 'public');

        // Publish views
        $this->publishes([
            __DIR__.'/views/' => base_path('/resources/views/vendor/bbcode')
        ], 'views');

        // Load views
        $this->loadViewsFrom(__DIR__.'/views', 'bbcode');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('bbcode', function($app)
        {
            return $this->app->make(LaravelBBCode::class);
        });

        // Merge config
        $this->mergeConfigFrom(__DIR__.'/config/bbcode.php', 'bbcode');

    }
}
