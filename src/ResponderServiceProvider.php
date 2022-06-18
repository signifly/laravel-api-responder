<?php

namespace R4nkt\Responder;

use Illuminate\Support\ServiceProvider;
use R4nkt\Responder\Contracts\ModelResolver as ModelResolverContract;
use R4nkt\Responder\Contracts\ResourceResolver as ResourceResolverContract;
use R4nkt\Responder\Contracts\Responder as ResponderContract;
use R4nkt\Responder\Support\ModelResolver;
use R4nkt\Responder\Support\ResourceResolver;

class ResponderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfigs();
        }

        $this->mergeConfigFrom(__DIR__.'/../config/responder.php', 'responder');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ResponderContract::class, function ($app) {
            return new Responder(
                $app->make(ModelResolver::class),
                $app->make(ResourceResolver::class)
            );
        });

        $this->app->singleton(ModelResolverContract::class, function ($app) {
            return new ModelResolver();
        });

        $this->app->singleton(ResourceResolverContract::class, function ($app) {
            return new ResourceResolver();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ResponderContract::class,
            ModelResolverContract::class,
            ResourceResolverContract::class,
        ];
    }

    protected function publishConfigs(): void
    {
        $this->publishes([
            __DIR__.'/../config/responder.php' => config_path('responder.php'),
        ], 'responder-config');
    }
}
