<?php

declare(strict_types=1);

use Modules\Hotel\Fakers\FakeSupplierAClient;
use Modules\Hotel\Transformers\SupplierATransformer;

it('transforms supplier A payloads into Hotel DTOs', function (): void {
    $transformer = new SupplierATransformer(new FakeSupplierAClient());
    $hotels = collect($transformer->handle());

    expect($hotels->count())->toBe(1);

    $first = $hotels->first();
    expect($first->id)->toBe('ID-1');
    expect($first->name)->toBe('Sheraton');
    expect($first->location)->toBe('Cairo, Egypt');
    expect($first->pricePerNight)->toBe(110.0);
});
