<?php

declare(strict_types=1);

namespace Modules\Hotel\Clients\Contract;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Modules\Hotel\Exceptions\SupplierEmptyResponseException;
use Modules\Hotel\Exceptions\SupplierUnavailableException;

interface SupplierClient
{
    /**
     * @return iterable
     *
     * @throws SupplierEmptyResponseException
     * @throws ConnectionException
     * @throws RequestException
     * @throws SupplierUnavailableException
     */
    public function handle();

    public function getName(): string;
}
