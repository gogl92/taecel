<?php namespace Taecel\Taecel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Taecel\Taecel\Commands\GenerarMatrizDePruebas;

class TaecelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/taecel.php', 'taecel');

        $this->publishConfig();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register facade
        $this->app->singleton('taecel', function () {
            return new Taecel(config('taecel.key'), config('taecel.nip'));
        });
    }

    /**
     * Publish Config
     *
     * @return void
     */
    public function publishConfig()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/Taecel.php' => config_path('Taecel.php'),
            ], 'config');
        }
    }
}
