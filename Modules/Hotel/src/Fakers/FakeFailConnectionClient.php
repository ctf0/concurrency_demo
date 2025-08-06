<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Illuminate\Support\Facades\Http;
use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\Enum\SuppliersName;

final class FakeFailConnectionClient implements SupplierClient
{
    public function handle(): iterable
    {
        Http::preventStrayRequests();
        Http::fake([
            'https://supplier_a.test/1' => Http::failedConnection(),
        ]);

        // ConnectionException
        Http::get('https://supplier_a.test/1')->throw();

        return [];
    }

    public function getName(): string
    {
        return SuppliersName::SUPPLIER_A;
    }
}
