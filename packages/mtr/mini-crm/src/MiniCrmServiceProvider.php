<?php

namespace Mtr\MiniCrm;

use Illuminate\Support\ServiceProvider;
use Mtr\MiniCrm\Console\Commands\InstallCommand;
use Illuminate\Pagination\Paginator;

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
            ->publishResources()
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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'minicrm');

        return $this;
    }

    /**
     * Publish package resources.
     * 
     * @return $this
     */
    protected function publishResources(): static
    {
        $this->publishes([
            __DIR__.'/../config/minicrm.php' => config_path('minicrm.php'),
        ], 'minicrm-config');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/minicrm'),
        ], 'minicrm-assets');

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