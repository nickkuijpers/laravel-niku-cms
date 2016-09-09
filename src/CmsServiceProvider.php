<?php

namespace Niku\Cms;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Package name
        $packageName = 'niku-cms';

        // Register migrations
        // $this->loadMigrationsFrom(__DIR__.'/migrations');

        // Register translations
        $this->loadTranslationsFrom(__DIR__.'/translations', $packageName);

        // Register config
        $this->publishes([
            __DIR__.'/config/'. $packageName .'.php' => config_path($packageName .'.php'),
        ]);

        // Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', $packageName);

        // Register copying views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/'. $packageName),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';        
    }
}
