<?php

namespace Mzm\Ilogin;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Mzm\Ilogin\View\Components\LoginButton;

class IloginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Publish configuration file
        $this->publishes([
            __DIR__ . '/../config/ilogin.php' => config_path('ilogin.php'),
        ], 'ilogin-config');


         // Publish views
         $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ilogin'),
        ], 'ilogin-views');

        // Load views from the package
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ilogin');

        // Register Blade components
        Blade::component('ilogin::loginbutton', LoginButton::class);
        // Blade::component('iloginbutton', LoginButton::class);

    }

    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/ilogin.php',
            'ilogin'
        );

        // Bind services
        $this->app->bind('SsoServices', function ($app) {
            return new \Mzm\Ilogin\Services\SsoServices();
        });
    }
}
