<?php

declare(strict_types=1);

namespace Modules\Hotel\Pipelines;

use Closure;
use Illuminate\Support\Enumerable;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Enum\DeDuplicationSortingField;

final class HotelDeduplicationPipe
{
    /**
     * @param  Enumerable<Hotel>  $hotels
     */
    public function handle(Enumerable $hotels, Closure $next): mixed
    {
        $deduplicatedHotels = $hotels
            ->groupBy(fn (Hotel $hotel) => $hotel->getDuplicationKey())
            ->map(fn (Enumerable $group) => $group->sortBy(DeDuplicationSortingField::PRICE, SORT_NUMERIC)->first())
            ->values();

        return $next($deduplicatedHotels);
    }
}
