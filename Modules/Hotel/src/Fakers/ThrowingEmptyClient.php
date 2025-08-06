<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\Enum\SuppliersName;
use Modules\Hotel\Exceptions\SupplierEmptyResponseException;

final class ThrowingEmptyClient implements SupplierClient
{
    public function handle(): iterable
    {
        throw new SupplierEmptyResponseException($this->getName());
    }

    public function getName(): string
    {
        return SuppliersName::SUPPLIER_A;
    }
}
