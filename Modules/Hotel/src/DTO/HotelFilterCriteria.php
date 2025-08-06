<?php

declare(strict_types=1);

namespace Modules\Hotel\DTO;

use Illuminate\Support\Carbon;
use Modules\Hotel\Enum\HotelSearchSorting;
use Modules\Hotel\Http\Requests\HotelSearchRequest;

final class HotelFilterCriteria
{
    public function __construct(
        public string $location,
        public Carbon $checkIn,
        public Carbon $checkOut,
        public ?int $guests,
        public ?int $minPrice,
        public ?int $maxPrice,
        public ?HotelSearchSorting $sortBy,
    ) {}

    public static function fromRequest(HotelSearchRequest $data): self
    {
        return new self(
            location: $data->string('location')->toString(),
            checkIn: $data->date('check_in'),
            checkOut: $data->date('check_out'),
            guests: $data->integer('guests'),
            minPrice: $data->integer('min_price'),
            maxPrice: $data->integer('max_price'),
            sortBy: $data->enum('sort_by', HotelSearchSorting::class, null),
        );
    }
}
