<?php

declare(strict_types=1);

namespace Modules\Hotel\Transformers\Traits;

trait SupplierData
{
    public function getName(): string
    {
        return $this->client->getName();
    }

    protected function chunkBy(): int
    {
        return config('system.suppliers_data_chunk');
    }
}
