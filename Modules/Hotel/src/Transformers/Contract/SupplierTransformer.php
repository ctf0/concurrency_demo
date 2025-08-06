<?php

declare(strict_types=1);

namespace Modules\Hotel\Transformers\Contract;

use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Exceptions\SupplierDataHasChangedException;
use Throwable;

interface SupplierTransformer
{
    /**
     * @return iterable<Hotel>
     *
     * @throws Throwable
     * @throws SupplierDataHasChangedException
     */
    public function handle(): iterable;

    public function getName(): string;
}
