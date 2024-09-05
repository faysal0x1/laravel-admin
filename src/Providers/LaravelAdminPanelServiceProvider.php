<?php

namespace YourVendor\LaravelAdmin\Providers;

use Illuminate\Support\ServiceProvider;
use Laratrust\LaratrustServiceProvider;
use Flasher\Laravel\FlasherServiceProvider;

class LaravelAdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/laravel-admin.php', 'laravel-admin'
        );

        // Register Laratrust
        $this->app->register(LaratrustServiceProvider::class);

        // Register Flasher
        $this->app->register(FlasherServiceProvider::class);
    }

    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-admin');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Publish configuration
        $this->publishes([
            __DIR__.'/../../config/laravel-admin.php' => config_path('laravel-admin.php'),
            __DIR__.'/../../config/laratrust.php' => config_path('laratrust.php'),
        ], 'config');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-admin'),
        ], 'views');

        // Publish assets
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/laravel-admin'),
        ], 'assets');

        // Register DataTables
        if (class_exists('Yajra\\DataTables\\DataTablesServiceProvider')) {
            $this->app->register('Yajra\\DataTables\\DataTablesServiceProvider');
        }
    }
}