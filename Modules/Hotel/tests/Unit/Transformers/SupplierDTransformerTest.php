<?php

declare(strict_types=1);

use Modules\Hotel\Fakers\FakeSupplierDClient;
use Modules\Hotel\Transformers\SupplierDTransformer;

it('transforms supplier D payloads into Hotel DTOs', function (): void {
    $transformer = new SupplierDTransformer(new FakeSupplierDClient());
    $hotels = collect($transformer->handle());

    expect($hotels->count())->toBe(1);

    $first = $hotels->first();
    expect($first->id)->toBe('D-55');
    expect($first->name)->toBe('D Suites');
    expect($first->location)->toBe('Paris, France');
    expect($first->pricePerNight)->toBe(300.0);
});
