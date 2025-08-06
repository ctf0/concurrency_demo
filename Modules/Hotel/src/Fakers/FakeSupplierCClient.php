<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\Enum\SuppliersName;

final class FakeSupplierCClient implements SupplierClient
{
    public function handle(): iterable
    {
        return [
            'hotels' => [
                [
                    'reference' => 'C-777',
                    'property_name' => 'C Resort',
                    'destination' => 'Tokyo',
                    'nation' => 'Japan',
                    'cost_per_night' => 220.0,
                    'vacancy' => 1,
                    'quality_score' => 4.8,
                    'geo' => [
                        'latitude' => 35.6762,
                        'longitude' => 139.6503,
                    ],
                ],
            ],
        ];
    }

    public function getName(): string
    {
        return SuppliersName::SUPPLIER_C;
    }
}
