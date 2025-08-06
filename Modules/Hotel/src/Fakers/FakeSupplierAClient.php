<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\Enum\SuppliersName;

final class FakeSupplierAClient implements SupplierClient
{
    public function handle(): iterable
    {
        return [
            [
                'hotel_id' => 'ID-1',
                'hotel_name' => 'Sheraton',
                'city' => 'Cairo',
                'country' => 'Egypt',
                'nightly_rate' => 110.0,
                'rooms_available' => 2,
                'star_rating' => 4.5,
                'coordinates' => ['lat' => 1.0, 'lng' => 2.0],
            ],
        ];
    }

    public function getName(): string
    {
        return SuppliersName::SUPPLIER_A;
    }
}
