<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\Enum\SuppliersName;

final class FakeSupplierDClient implements SupplierClient
{
    public function handle(): iterable
    {
        return [
            'data' => [
                'properties' => [
                    [
                        'property_id' => 'D-55',
                        'title' => 'D Suites',
                        'city_name' => 'Paris',
                        'country_code' => 'FR',
                        'room_rate' => 300.0,
                        'rooms_left' => 3,
                        'guest_rating' => 4.1,
                        'coordinates' => [48.8566, 2.3522],
                    ],
                ],
            ],
        ];
    }

    public function getName(): string
    {
        return SuppliersName::SUPPLIER_D;
    }
}
