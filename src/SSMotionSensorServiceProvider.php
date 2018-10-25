<?php

namespace Tchoblond59\SSMotionSensor;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class SSMotionSensorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/assets/js' => public_path('/js/tchoblond59/ssmotionsensor'),
        ], 'larahome-package');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        //$this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'ssmotion');

        Event::listen('App\Events\MSMessageEvent', '\Tchoblond59\SSMotionSensor\EventListener\SSMotionSensorEventListener');
    }

    public function register()
    {

    }
}
