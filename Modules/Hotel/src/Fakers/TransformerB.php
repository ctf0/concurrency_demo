<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Modules\Hotel\Exceptions\SupplierBaseException;
use Modules\Hotel\Transformers\Contract\SupplierTransformer;

final class TransformerB implements SupplierTransformer
{
    public function handle(): iterable
    {
        throw new SupplierBaseException();
    }

    public function getName(): string
    {
        return 'supplier_bad';
    }
}
