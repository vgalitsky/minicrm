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
        $this
            ->loadMigrations()
            ->loadRoutes()
            ->loadViews()
            ->registerCommands();
    }

    /**
     * Load package migrations.
     * 
     * @return $this
     */
    protected function loadMigrations(): static
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        return $this;
    }

    /**
     * Load package routes.
     * 
     * @return $this
     */
    protected function loadRoutes(): static
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        return $this;
    }

    /**
     * Load package views.
     * 
     * @return $this
     */
    protected function loadViews(): static
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mini-crm');

        return $this;
    }

    /**
     * Register package commands.
     * 
     * @return $this
     */
    protected function registerCommands(): static
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
        
        return $this;
    }
}