<?php

namespace Mtr\MiniCrm;

use Illuminate\Support\ServiceProvider;
use Mtr\MiniCrm\Console\Commands\InstallCommand;

class MiniCrmServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}