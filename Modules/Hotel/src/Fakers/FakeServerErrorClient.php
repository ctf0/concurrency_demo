<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Illuminate\Support\Facades\Http;
use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\Enum\SuppliersName;

final class FakeServerErrorClient implements SupplierClient
{
    public function handle(): iterable
    {
        Http::preventStrayRequests();
        Http::fake([
            'https://supplier_a.test/2' => Http::response(null, 500),
        ]);

        // RequestException
        Http::get('https://supplier_a.test/2')->throw();

        return [];
    }

    public function getName(): string
    {
        return SuppliersName::SUPPLIER_A;
    }
}
