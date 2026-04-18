<?php

namespace Interdotz\Laravel;

use Illuminate\Support\ServiceProvider;
use Interdotz\Sdk\InterdotzClient;

class InterdotzServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            path: __DIR__ . '/../config/interdotz.php',
            key: 'interdotz',
        );

        $this->app->singleton(InterdotzClient::class, function () {
            return new InterdotzClient(
                clientId:     config('interdotz.client_id'),
                clientSecret: config('interdotz.client_secret'),
                httpOptions:  [
                    'timeout' => config('interdotz.http.timeout', 10),
                ],
            );
        });
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'interdotz');

        $this->publishes([
            __DIR__ . '/../config/interdotz.php' => config_path('interdotz.php'),
        ], 'interdotz-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/interdotz'),
        ], 'interdotz-views');
    }
}
