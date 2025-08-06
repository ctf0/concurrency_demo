<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\DTO\HotelFilterCriteria;
use Modules\Hotel\Enum\HotelSearchSorting;
use Modules\Hotel\Enum\SuppliersName;
use Modules\Hotel\Pipelines\HotelFilterPipe;

function makeFilterableHotel(array $other = []): Hotel
{
    $default = [
        'id' => '1',
        'name' => 'Sheraton',
        'location' => 'Cairo, Egypt',
        'pricePerNight' => 100.0,
        'availableRooms' => 2,
        'rating' => 4.0,
        'source' => SuppliersName::SUPPLIER_A,
        'coordinates' => ['lat' => 1.0, 'lng' => 2.0],
    ];

    return Hotel::fromArray(array_merge($default, $other));
}

it('filters by location and price and guests', function (): void {
    $criteria = new HotelFilterCriteria(
        location: 'Cairo, Egypt',
        checkIn: Carbon::parse('2025-08-10'),
        checkOut: Carbon::parse('2025-08-12'),
        guests: 2,
        minPrice: 50,
        maxPrice: 200,
        sortBy: HotelSearchSorting::PRICE,
    );

    $pipe = new HotelFilterPipe($criteria);

    $hotels = collect([
        makeFilterableHotel(['pricePerNight' => 40]), // too cheap (<= min)
        makeFilterableHotel(['pricePerNight' => 100]), // ok
        makeFilterableHotel(['availableRooms' => 1]), // not enough rooms
        makeFilterableHotel(['location' => 'Alexandria, Egypt']), // wrong location
        makeFilterableHotel(['pricePerNight' => 250]), // too expensive (>= max)
    ]);

    $result = $pipe->handle($hotels, fn ($h) => $h);

    expect($result)->toHaveCount(1);
    expect($result->first()->pricePerNight)->toBe(100.0);
});
