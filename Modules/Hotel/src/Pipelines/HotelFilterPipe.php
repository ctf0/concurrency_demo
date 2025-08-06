<?php

declare(strict_types=1);

namespace Modules\Hotel\Pipelines;

use Closure;
use Illuminate\Support\Enumerable;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\DTO\HotelFilterCriteria;

final class HotelFilterPipe
{
    public function __construct(
        private HotelFilterCriteria $hotelFilterCriteria
    ) {}

    /**
     * @param  Enumerable<Hotel>  $hotels
     */
    public function handle(Enumerable $hotels, Closure $next): mixed
    {
        $hotelFilterCriteria = $this->hotelFilterCriteria;

        $filteredHotels = $hotels->filter(function (Hotel $hotel) use ($hotelFilterCriteria) {
            // location
            if ($hotel->location !== $hotelFilterCriteria->location) {
                return false;
            }

            // pricePerNight
            if ($hotelFilterCriteria->minPrice) {
                if ($hotel->pricePerNight <= $hotelFilterCriteria->minPrice) {
                    return false;
                }
            }

            if ($hotelFilterCriteria->maxPrice) {
                if ($hotel->pricePerNight >= $hotelFilterCriteria->maxPrice) {
                    return false;
                }
            }

            // guest
            if ($hotelFilterCriteria->guests > 0) {
                if ($hotel->availableRooms < $hotelFilterCriteria->guests) {
                    return false;
                }
            }

            return true;
        })->values();

        return $next($filteredHotels);
    }
}
