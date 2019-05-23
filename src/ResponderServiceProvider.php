<?php

namespace Signifly\Responder;

use Illuminate\Support\ServiceProvider;
use Signifly\Responder\Support\ModelResolver;
use Signifly\Responder\Support\ResourceResolver;
use Signifly\Responder\Contracts\Responder as ResponderContract;
use Signifly\Responder\Contracts\ModelResolver as ModelResolverContract;
use Signifly\Responder\Contracts\ResourceResolver as ResourceResolverContract;

class ResponderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
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
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
