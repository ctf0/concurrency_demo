<?php

declare(strict_types=1);

use App\Http\Middleware\CheckForApiHeaderExistence;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Concurrency;

it('validates request successfully with full valid payload', function (): void {
    $this->withoutMiddleware(CheckForApiHeaderExistence::class);

    Carbon::setTestNow('2025-08-01');

    Concurrency::shouldReceive('run')->andReturn([
        ['supplier' => 'A', 'hotels' => [], 'success' => true],
    ]);

    $res = $this->getJson(route('api.hotels.search', [
        'location' => 'Berlin, Germany',
        'check_in' => '2025-08-10',
        'check_out' => '2025-08-12',
        'guests' => 2,
        'min_price' => 100,
        'max_price' => 200,
        'sort_by' => 'price',
    ]));

    $res->assertOk()
        ->assertJson([
            'total' => 0,
            'data' => [],
        ]);

    Carbon::setTestNow();
});

it('fails validation with invalid or missing fields', function (): void {
    $this->withoutMiddleware(CheckForApiHeaderExistence::class);

    Carbon::setTestNow('2025-08-01');

    $res = $this->getJson(route('api.hotels.search', [
        'check_in' => '2025-08-10',
        'check_out' => '2025-08-09',
        'guests' => -1,
        'min_price' => 100,
        'max_price' => 50,
        'sort_by' => 'invalid',
    ]));

    $res->assertStatus(422)
        ->assertInvalid([
            'location',
            'check_out',
            'guests',
            'max_price',
            'sort_by',
        ]);

    Carbon::setTestNow();
});
