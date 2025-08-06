<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Transformers\Contract\SupplierTransformer;

final class TransformerA implements SupplierTransformer
{
    public function handle(): iterable
    {
        return collect([
            Hotel::fromArray([
                'id' => 'OK-1',
                'name' => 'Ok Hotel 1',
                'location' => 'City, Country',
                'pricePerNight' => 100.0,
                'availableRooms' => 2,
                'rating' => 4.0,
                'source' => $this->getName(),
                'coordinates' => ['lat' => 0, 'lng' => 0],
            ]),
            Hotel::fromArray([
                'id' => 'OK-2',
                'name' => 'Ok Hotel 2',
                'location' => 'City, Country',
                'pricePerNight' => 120.0,
                'availableRooms' => 1,
                'rating' => 4.5,
                'source' => $this->getName(),
                'coordinates' => ['lat' => 1, 'lng' => 1],
            ]),
        ]);
    }

    public function getName(): string
    {
        return 'supplier_ok';
    }
}
