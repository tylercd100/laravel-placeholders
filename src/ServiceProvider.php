<?php

namespace Tylercd100\Placeholders;

use Illuminate\Support\ServiceProvider as IlluminateProvider;
use Tylercd100\Placeholders\Placeholders;

class ServiceProvider extends IlluminateProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/placeholders.php' => base_path('config/placeholders.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/placeholders.php', 'placeholders');
        $this->app->singleton("placeholders", function ($app) {
            return new Placeholders(config('placeholders'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ["placeholders"];
    }
}
