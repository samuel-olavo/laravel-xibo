<?php

namespace SamuelOlavo\LaravelXibo;

use Illuminate\Support\ServiceProvider;
use SamuelOlavo\LaravelXibo\Connections\ConnectionManager;

final class XiboServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/xibo.php', 'xibo');
        $this->app->singleton(ConnectionManager::class, fn ($app) => new ConnectionManager(
            $app['config'],
            $app->make(\SamuelOlavo\LaravelXibo\Spec\Repository::class),
            $app->make(\SamuelOlavo\LaravelXibo\Http\Executor::class),
        ));
        $this->app->alias(ConnectionManager::class, 'xibo');
    }

    public function boot(): void
    {
        $this->publishes([__DIR__.'/../config/xibo.php' => config_path('xibo.php')], 'xibo-config');
    }
}
