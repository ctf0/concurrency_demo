<?php

declare(strict_types=1);

namespace Modules\Hotel\Fakers;

use Modules\Hotel\Transformers\Contract\SupplierTransformer;
use RuntimeException;

final class FakeChangingTransformer implements SupplierTransformer
{
    public function handle(): iterable
    {
        // Trigger the decorator's pattern: message contains 'Undefined array key'
        throw new RuntimeException('Undefined array key "hotel_id"');
    }

    public function getName(): string
    {
        return 'supplier_x';
    }
}
