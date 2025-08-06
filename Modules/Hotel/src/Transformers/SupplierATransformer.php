<?php

declare(strict_types=1);

namespace Modules\Hotel\Transformers;

use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Transformers\Contract\SupplierTransformer;
use Modules\Hotel\Transformers\Traits\SupplierData;

final class SupplierATransformer implements SupplierTransformer
{
    use SupplierData;

    public function __construct(
        public SupplierClient $client
    ) {}

    public function handle(): iterable
    {
        return collect($this->client->handle())
            ->chunk($this->chunkBy())
            ->flatMap(fn ($chunk) => collect($chunk)->map(fn ($hotel) => Hotel::fromArray([
                'id' => $hotel['hotel_id'],
                'name' => $hotel['hotel_name'],
                'location' => "{$hotel['city']}, {$hotel['country']}",
                'pricePerNight' => $hotel['nightly_rate'],
                'availableRooms' => $hotel['rooms_available'],
                'rating' => $hotel['star_rating'],
                'source' => $this->getName(),
                'coordinates' => $hotel['coordinates'],
            ])));
    }
}
