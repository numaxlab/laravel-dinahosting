<?php

namespace NumaxLab\Laravel\Dinahosting;

use Illuminate\Support\ServiceProvider;
use NumaxLab\Laravel\Dinahosting\Console\Commands\DinahostingSymlink;
use NumaxLab\Laravel\Dinahosting\Console\Commands\EnvoySetup;

class LaravelDinahostingServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DinahostingSymlink::class,
                EnvoySetup::class,
            ]);
        }
    }
}