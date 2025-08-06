<?php

declare(strict_types=1);

namespace Modules\Hotel\Clients\Decorator;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Modules\Hotel\Clients\Contract\SupplierClient;
use Modules\Hotel\Exceptions\SupplierEmptyResponseException;
use Modules\Hotel\Exceptions\SupplierUnavailableException;

final class SupplierClientDecorator implements SupplierClient
{
    public function __construct(
        public SupplierClient $supplierClient,
    ) {}

    public function handle(): iterable
    {
        try {
            $supplier = $this->getName();
            $ttl = config('system.suppliers_data_cache_ttl');

            return Cache::remember("supplier_data:{$supplier}", $ttl, fn () => $this->supplierClient->handle());
        } catch (SupplierEmptyResponseException $e) {
            return [];
        } catch (ConnectionException $e) {
            throw new SupplierUnavailableException($this->getName(), previous: $e);
        } catch (RequestException $e) {
            // ASK: maybe queue the request ?
            throw new SupplierUnavailableException($this->getName(), previous: $e);
        }
    }

    public function getName(): string
    {
        return $this->supplierClient->getName();
    }
}
