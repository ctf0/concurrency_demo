<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\Enum\SuppliersName;

final class FakeSupplierBClient implements SupplierClient
{
    public function handle(): iterable
    {
        return [
            [
                'id' => 'B-100',
                'name' => 'Hilton',
                'location' => 'Berlin, Germany',
                'price' => 150.5,
                'available' => 5,
                'rating' => 4.2,
                'lat' => 52.52,
                'long' => 13.405,
            ],
        ];
    }

    public function getName(): string
    {
        return SuppliersName::SUPPLIER_B;
    }
}
