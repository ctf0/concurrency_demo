<?php

declare(strict_types=1);

use Modules\Hotel\Fakers\FakeSupplierCClient;
use Modules\Hotel\Transformers\SupplierCTransformer;

it('transforms supplier C payloads into Hotel DTOs', function (): void {
    $transformer = new SupplierCTransformer(new FakeSupplierCClient());
    $hotels = collect($transformer->handle());

    expect($hotels->count())->toBe(1);

    $first = $hotels->first();
    expect($first->id)->toBe('C-777');
    expect($first->name)->toBe('C Resort');
    expect($first->location)->toBe('Tokyo, Japan');
    expect($first->pricePerNight)->toBe(220.0);
});
