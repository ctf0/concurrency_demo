<?php

declare(strict_types=1);

namespace Modules\Hotel\Transformers;

use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Transformers\Contract\SupplierTransformer;
use Modules\Hotel\Transformers\Traits\SupplierData;

final class SupplierDTransformer implements SupplierTransformer
{
    use SupplierData;

    public function __construct(
        public SupplierClient $client
    ) {}

    public function handle(): iterable
    {
        return collect(data_get($this->client->handle(), 'data.properties', []))
            ->chunk($this->chunkBy())
            ->flatMap(fn ($chunk) => collect($chunk)->map(fn ($hotel) => Hotel::fromArray([
                'id' => $hotel['property_id'],
                'name' => $hotel['title'],
                'location' => "{$hotel['city_name']}, {$this->getCountryName($hotel['country_code'])}",
                'pricePerNight' => $hotel['room_rate'],
                'availableRooms' => $hotel['rooms_left'],
                'rating' => $hotel['guest_rating'],
                'source' => 'supplier_d',
                'coordinates' => [
                    'lat' => $hotel['coordinates'][0],
                    'lng' => $hotel['coordinates'][1],
                ],
            ])));
    }

    private function getCountryName(string $countryCode): string
    {
        $countries = [
            'FR' => 'France',
            'US' => 'USA',
            'GB' => 'UK',
            'ES' => 'Spain',
        ];

        return $countries[$countryCode] ?? 'Global';
    }
}
