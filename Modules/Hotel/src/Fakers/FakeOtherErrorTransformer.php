<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Modules\Hotel\Transformers\Contract\SupplierTransformer;
use RuntimeException;

final class FakeOtherErrorTransformer implements SupplierTransformer
{
    public function handle(): iterable
    {
        throw new RuntimeException();
    }

    public function getName(): string
    {
        return 'supplier_x';
    }
}
