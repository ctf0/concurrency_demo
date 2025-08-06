<?php

declare(strict_types=1);

namespace Modules\Hotel\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Hotel\Clients\Decorator\SupplierClientDecorator;
use Modules\Hotel\Clients\SupplierAClient;
use Modules\Hotel\Clients\SupplierBClient;
use Modules\Hotel\Clients\SupplierCClient;
use Modules\Hotel\Clients\SupplierDClient;
use Modules\Hotel\Services\SuppliersDataAggregator;
use Modules\Hotel\Transformers\Contract\SupplierTransformer;
use Modules\Hotel\Transformers\Decorator\SupplierTransformerDecorator;
use Modules\Hotel\Transformers\SupplierATransformer;
use Modules\Hotel\Transformers\SupplierBTransformer;
use Modules\Hotel\Transformers\SupplierCTransformer;
use Modules\Hotel\Transformers\SupplierDTransformer;

final class HotelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // clients
        // http, database, file, etc.
        $this->app->singleton(SupplierAClient::class, fn () => new SupplierClientDecorator(new SupplierAClient()));
        $this->app->singleton(SupplierBClient::class, fn () => new SupplierClientDecorator(new SupplierBClient()));
        $this->app->singleton(SupplierCClient::class, fn () => new SupplierClientDecorator(new SupplierCClient()));
        $this->app->singleton(SupplierDClient::class, fn () => new SupplierClientDecorator(new SupplierDClient()));

        // transformers
        // client data > dto
        $this->app->singleton(SupplierATransformer::class, fn ($app) => new SupplierTransformerDecorator(new SupplierATransformer($app->make(SupplierAClient::class))));
        $this->app->singleton(SupplierBTransformer::class, fn ($app) => new SupplierTransformerDecorator(new SupplierBTransformer($app->make(SupplierBClient::class))));
        $this->app->singleton(SupplierCTransformer::class, fn ($app) => new SupplierTransformerDecorator(new SupplierCTransformer($app->make(SupplierCClient::class))));
        $this->app->singleton(SupplierDTransformer::class, fn ($app) => new SupplierTransformerDecorator(new SupplierDTransformer($app->make(SupplierDClient::class))));

        // aggregator
        $this->app->when(SuppliersDataAggregator::class)->needs(SupplierTransformer::class)->give([
            SupplierATransformer::class,
            SupplierBTransformer::class,
            SupplierCTransformer::class,
            SupplierDTransformer::class,
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
