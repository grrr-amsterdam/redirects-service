<?php

namespace Grrr\Redirects\Nova;

use Illuminate\Support\ServiceProvider;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'nova-redirects');

        $this->publishes(
            [
                __DIR__ . '/../config/nova-redirects.php' => config_path(
                    'nova-redirects.php'
                ),
            ],
            'config'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/nova-redirects.php',
            'nova-redirects'
        );
    }
}
