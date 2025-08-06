<?php

declare(strict_types=1);

namespace Modules\Hotel\Clients;

use Illuminate\Support\Facades\Http;
use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\Clients\Traits\RequestConditions;
use Modules\Hotel\Enum\SuppliersName;
use Modules\Hotel\Exceptions\SupplierEmptyResponseException;

use function count;

final class SupplierAClient implements SupplierClient
{
    use RequestConditions;

    public function handle(): iterable
    {
        $url = $this->simulate();

        $response = Http::get($url)->throw()->json(default: []);

        if (count($response) === 0) {
            throw new SupplierEmptyResponseException($this->getName());
        }

        return $response;
    }

    public function getName(): string
    {
        return SuppliersName::SUPPLIER_A;
    }
}
