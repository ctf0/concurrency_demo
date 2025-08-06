<?php

declare(strict_types=1);

use Modules\Hotel\Fakers\FakeSupplierBClient;
use Modules\Hotel\Transformers\SupplierBTransformer;

it('transforms supplier B payloads into Hotel DTOs', function (): void {
    $transformer = new SupplierBTransformer(new FakeSupplierBClient());
    $hotels = collect($transformer->handle());

    expect($hotels->count())->toBe(1);

    $first = $hotels->first();
    expect($first->id)->toBe('B-100');
    expect($first->name)->toBe('Hilton');
    expect($first->location)->toBe('Berlin, Germany');
    expect($first->pricePerNight)->toBe(150.5);
});
