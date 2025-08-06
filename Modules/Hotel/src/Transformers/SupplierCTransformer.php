<?php

declare(strict_types=1);

namespace Modules\Hotel\Transformers;

use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Transformers\Contract\SupplierTransformer;
use Modules\Hotel\Transformers\Traits\SupplierData;

final class SupplierCTransformer implements SupplierTransformer
{
    use SupplierData;

    public function __construct(
        public SupplierClient $client
    ) {}

    public function handle(): iterable
    {
        return collect(data_get($this->client->handle(), 'hotels', []))
            ->chunk($this->chunkBy())
            ->flatMap(fn ($chunk) => collect($chunk)->map(fn ($hotel) => Hotel::fromArray([
                'id' => $hotel['reference'],
                'name' => $hotel['property_name'],
                'location' => "{$hotel['destination']}, {$hotel['nation']}",
                'pricePerNight' => $hotel['cost_per_night'],
                'availableRooms' => $hotel['vacancy'],
                'rating' => $hotel['quality_score'],
                'source' => $this->getName(),
                'coordinates' => [
                    'lat' => $hotel['geo']['latitude'],
                    'lng' => $hotel['geo']['longitude'],
                ],
            ])));
    }
}
