<?php

declare(strict_types=1);

namespace Modules\Hotel\Http\Actions;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Enumerable;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\DTO\HotelFilterCriteria;
use Modules\Hotel\Pipelines\HotelDeduplicationPipe;
use Modules\Hotel\Pipelines\HotelFilterPipe;
use Modules\Hotel\Pipelines\HotelSortingPipe;
use Modules\Hotel\Services\SuppliersDataAggregator;

final class HotelSearch
{
    public function __construct(
        private SuppliersDataAggregator $suppliersDataAggregator
    ) {}

    /**
     * @return Enumerable<Hotel>
     */
    public function handle(HotelFilterCriteria $hotelFilterCriteria): Enumerable
    {
        return app(Pipeline::class)
            ->send($this->suppliersDataAggregator->handle())
            ->through([
                new HotelFilterPipe($hotelFilterCriteria),
                new HotelDeduplicationPipe(),
                new HotelSortingPipe($hotelFilterCriteria->sortBy),
            ])
            ->then(fn (Enumerable $hotels) => $hotels);
    }
}
