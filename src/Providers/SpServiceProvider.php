<?php

namespace Amdbl\Sp\Providers;

use Amdbl\Sp\Splayer;
use Illuminate\Support\ServiceProvider;

class SpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $confPath = realpath(__DIR__ . '/../config/splayer.php');
        $this->publishes([
            $confPath => config_path('splayer.php'),
        ]);
        $this->mergeConfigFrom($confPath, 'splayer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('amdbl.splayer', function ($app) {
            return new Splayer();
        });
    }

}