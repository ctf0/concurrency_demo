<?php

declare(strict_types=1);

use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Pipelines\HotelDeduplicationPipe;

function makeDupHotel(string $name, string $location, float $price): Hotel
{
    return Hotel::fromArray([
        'id' => uniqid('id', true),
        'name' => $name,
        'location' => $location,
        'pricePerNight' => $price,
        'availableRooms' => 2,
        'rating' => 4.0,
        'source' => 'SupplierX',
        'coordinates' => ['lat' => 1.0, 'lng' => 2.0],
    ]);
}

it('keeps the cheapest per deduplication key', function (): void {
    $pipe = new HotelDeduplicationPipe();

    $hotels = collect([
        makeDupHotel('Sheraton', 'Cairo, Egypt', 120),
        makeDupHotel('Sheraton', 'Cairo, Egypt', 90),
        makeDupHotel('Hilton', 'Cairo, Egypt', 200),
        makeDupHotel('Hilton', 'Cairo, Egypt', 180),
        makeDupHotel('Marriott', 'Alexandria, Egypt', 300),
    ]);

    $result = $pipe->handle($hotels, fn ($h) => $h);

    expect($result)->toHaveCount(3);
    expect($result->pluck('name')->all())->toEqualCanonicalizing(['Sheraton', 'Hilton', 'Marriott']);

    $sheraton = $result->firstWhere('name', 'Sheraton');
    expect($sheraton->pricePerNight)->toBe(90.0);

    $hilton = $result->firstWhere('name', 'Hilton');
    expect($hilton->pricePerNight)->toBe(180.0);
});
