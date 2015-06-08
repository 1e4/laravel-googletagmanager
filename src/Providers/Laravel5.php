<?php

namespace Spatie\GoogleTagManager\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\GoogleTagManager\GoogleTagManager;

class Laravel5 extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'googletagmanager');

        $this->publishes([
            __DIR__.'/../resources/config/config.php' => config_path('googletagmanager.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/googletagmanager'),
        ], 'views');

        $this->app['view']->creator(
            ['googletagmanager::script', 'googletagmanager::push'],
            'Spatie\GoogleTagManager\ScriptViewCreator'
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../resources/config/config.php', 'googletagmanager');

        $googleTagManager = new GoogleTagManager(config('googletagmanager.id'));

        if (config('googletagmanager.enabled') === false) {
            $googleTagManager->disable();
        }

        $this->app->instance('Spatie\GoogleTagManager\GoogleTagManager', $googleTagManager);
        $this->app->alias('Spatie\GoogleTagManager\GoogleTagManager', 'googletagmanager');
    }
}
