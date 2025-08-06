<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Concurrency;
use Modules\Hotel\Exceptions\SupplierDataAggregatorException;
use Modules\Hotel\Fakers\FailingSupplierTransformer;
use Modules\Hotel\Services\SuppliersDataAggregator;

it('aggregator throws SupplierDataAggregatorException when Concurrency::run fails', function (): void {
    Concurrency::shouldReceive('run')->once()->andThrow(new \RuntimeException());

    $agg = new SuppliersDataAggregator(new FailingSupplierTransformer());

    expect(fn () => $agg->handle())->toThrow(SupplierDataAggregatorException::class);
});
