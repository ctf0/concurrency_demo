<?php

declare(strict_types=1);

use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Enum\HotelSearchSorting;
use Modules\Hotel\Enum\SuppliersName;
use Modules\Hotel\Pipelines\HotelSortingPipe;

function makeSortableHotel(string $name, float $price, float $rating): Hotel
{
    return Hotel::fromArray([
        'id' => $name,
        'name' => $name,
        'location' => 'Cairo, Egypt',
        'pricePerNight' => $price,
        'availableRooms' => 2,
        'rating' => $rating,
        'source' => SuppliersName::SUPPLIER_A,
        'coordinates' => ['lat' => 1.0, 'lng' => 2.0],
    ]);
}

it('sorts by price ascending', function (): void {
    $pipe = new HotelSortingPipe(HotelSearchSorting::PRICE);

    $hotels = collect([
        makeSortableHotel('Sheraton', 150, 3.5),
        makeSortableHotel('Hilton', 100, 4.8),
        makeSortableHotel('Marriott', 120, 4.0),
    ]);

    $result = $pipe->handle($hotels, fn ($h) => $h);

    expect($result->pluck('name')->all())->toBe(['Hilton', 'Marriott', 'Sheraton']);
});

it('sorts by rating descending', function (): void {
    $pipe = new HotelSortingPipe(HotelSearchSorting::RATING);

    $hotels = collect([
        makeSortableHotel('Sheraton', 150, 3.5),
        makeSortableHotel('Hilton', 100, 4.8),
        makeSortableHotel('Marriott', 120, 4.0),
    ]);

    $result = $pipe->handle($hotels, fn ($h) => $h);

    expect($result->pluck('name')->all())->toBe(['Hilton', 'Marriott', 'Sheraton']);
});

it('no sorting when sortBy is null', function (): void {
    $pipe = new HotelSortingPipe(null);

    $hotels = collect([
        makeSortableHotel('Sheraton', 150, 3.5),
        makeSortableHotel('Hilton', 100, 4.8),
        makeSortableHotel('Marriott', 120, 4.0),
    ]);

    $result = $pipe->handle($hotels, fn ($h) => $h);

    expect($result->pluck('name')->all())->toBe(['Sheraton', 'Hilton', 'Marriott']);
});
