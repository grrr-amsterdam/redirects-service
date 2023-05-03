<?php

namespace Grrr\Redirects\Nova;

use Exception;
use Grrr\Redirects\Nova\Events\RedirectIsCreated;
use Grrr\Redirects\Nova\Events\RedirectIsDeleted;
use Grrr\Redirects\Nova\Events\RedirectIsUpdated;
use Grrr\Redirects\Nova\Listeners\DeleteRedirectFromDynamoDb;
use Grrr\Redirects\Nova\Listeners\StoreRedirectInApi;
use Grrr\Redirects\Nova\Listeners\UpdateRedirectInDynamoDb;
use Illuminate\Support\Facades\Event;
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
        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        $this->loadTranslationsFrom(
            __DIR__ . "/../resources/lang",
            "nova-redirects"
        );

        $this->publishes(
            [
                __DIR__ . "/../config/nova-redirects.php" => config_path(
                    "nova-redirects.php"
                ),
            ],
            "config"
        );

        Event::listen(RedirectIsCreated::class, StoreRedirectInApi::class);
        Event::listen(
            RedirectIsDeleted::class,
            DeleteRedirectFromDynamoDb::class
        );
        Event::listen(
            RedirectIsUpdated::class,
            UpdateRedirectInDynamoDb::class
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
            __DIR__ . "/../config/nova-redirects.php",
            "nova-redirects"
        );

        $this->app->singleton(RedirectsApi::class, function () {
            $apiUrl = config("nova-redirects.api_url");
            if (!is_string($apiUrl)) {
                throw new Exception(
                    "Redirects API URL is not configured. Add to `config/nova-redirects.php`."
                );
            }
            return new RedirectsApi(strval($apiUrl));
        });
    }
}
