<?php

declare(strict_types=1);

namespace Modules\Hotel\Pipelines;

use Closure;
use Illuminate\Support\Enumerable;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Enum\HotelSearchSorting;

final class HotelSortingPipe
{
    public function __construct(
        private ?HotelSearchSorting $sortBy
    ) {}

    /**
     * @param  Enumerable<Hotel>  $hotels
     */
    public function handle(Enumerable $hotels, Closure $next): mixed
    {
        $sortBy = $this->sortBy;

        if (! $sortBy) {
            return $next($hotels);
        }

        $sortedHotels = $hotels
            ->sortBy(function (Hotel $hotel) use ($sortBy) {
                return match ($sortBy) {
                    HotelSearchSorting::PRICE => $hotel->pricePerNight,
                    HotelSearchSorting::RATING => $hotel->rating,
                };
            }, SORT_NUMERIC, $sortBy === HotelSearchSorting::RATING)
            ->values();

        return $next($sortedHotels);
    }
}
