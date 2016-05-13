<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->registerServiceProviders();
        }
    }

    /**
     * Регистрация ServiceProviders в ручном режиме.
     */
    private function registerServiceProviders()
    {
        $providers = [];

        if (class_exists('\Barryvdh\Debugbar\ServiceProvider')) {
            array_pull($providers, '\Barryvdh\Debugbar\ServiceProvider');
        }

        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }
}
