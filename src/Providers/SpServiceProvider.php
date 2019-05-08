<?php
namespace Amdbl\Sp\Providers;
use Amdbl\Sp\SpLib;
use Illuminate\Support\ServiceProvider;
class PermitServiceProvider extends ServiceProvider
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
        $this->app->singleton('amdbl.sp', function ($app) {
            return new SpLib();
        });
    }

}