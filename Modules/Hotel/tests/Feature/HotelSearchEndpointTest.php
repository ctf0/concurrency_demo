<?php

declare(strict_types=1);

use App\Http\Middleware\CheckForApiHeaderExistence;
use Illuminate\Support\Facades\Concurrency;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Enum\SuppliersName;

it('returns 200 with empty results shape', function (): void {
    $this->withoutMiddleware(CheckForApiHeaderExistence::class);

    // Make aggregator yield no hotels from any supplier
    Concurrency::shouldReceive('run')->andReturn([
        ['supplier' => 'A', 'hotels' => [], 'success' => true],
        ['supplier' => 'B', 'hotels' => [], 'success' => true],
    ]);

    $res = $this->getJson(route('api.hotels.search', [
        'location' => 'Cairo, Egypt',
        'check_in' => '2025-08-10',
        'check_out' => '2025-08-12',
    ]));

    $res->assertOk()
        ->assertJson([
            'total' => 0,
            'data' => [],
        ]);
});

it('returns 200 with hotels from the pipeline', function (): void {
    $this->withoutMiddleware(CheckForApiHeaderExistence::class);

    $hotel = Hotel::fromArray([
        'id' => '1',
        'name' => 'Demo Hotel',
        'location' => 'Cairo, Egypt',
        'pricePerNight' => 120.5,
        'availableRooms' => 3,
        'rating' => 4.2,
        'source' => SuppliersName::SUPPLIER_A,
        'coordinates' => [
            'lat' => 40.0,
            'lng' => -74.0,
        ],
    ]);

    Concurrency::shouldReceive('run')->andReturn([
        ['supplier' => SuppliersName::SUPPLIER_A, 'hotels' => [$hotel], 'success' => true],
    ]);

    $res = $this->getJson(route('api.hotels.search', [
        'location' => 'Cairo, Egypt',
        'check_in' => '2025-08-10',
        'check_out' => '2025-08-12',
    ]));

    $res->assertOk()
        ->assertJsonPath('total', 1)
        ->assertJsonFragment(['name' => 'Demo Hotel']);
});
