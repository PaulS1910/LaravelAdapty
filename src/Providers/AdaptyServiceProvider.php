<?php

namespace PS\LaravelAdapty\Providers;

use Illuminate\Support\ServiceProvider;

class AdaptyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('adapty', function ($app) {
            return new \PS\LaravelAdapty\Services\AdaptyService();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/adapty.php' => config_path('adapty.php'),
        ], 'adapty-config');
    }
}