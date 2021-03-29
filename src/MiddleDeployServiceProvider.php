<?php

namespace Yan9\MiddleDeploy;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class MiddleDeployServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('middleDeploy', \Yan9\MiddleDeploy\Middleware\MiddleDeployMiddleware::class);

        $this->publishes([
            __DIR__.'/Config/middleDeploy.php' => config_path('middleDeploy.php'),
        ], 'middleDeploy_config');

        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/Translations', 'middleDeploy');

        $this->publishes([
            __DIR__ . '/Translations' => resource_path('lang/vendor/middleDeploy'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/Views', 'middleDeploy');

        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/middleDeploy'),
        ]);

        $this->publishes([
            __DIR__ . '/Assets' => public_path('vendor/middleDeploy'),
        ], 'middleDeploy_assets');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Yan9\MiddleDeploy\Commands\MiddleDeployCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/middleDeploy.php', 'middleDeploy'
        );
    }
}
