<?php

declare(strict_types=1);

namespace Modules\Hotel\Transformers\Decorator;

use Modules\Hotel\Exceptions\SupplierDataHasChangedException;
use Modules\Hotel\Transformers\Contract\SupplierTransformer;
use Throwable;

final class SupplierTransformerDecorator implements SupplierTransformer
{
    public function __construct(
        public SupplierTransformer $supplierTransformer
    ) {}

    public function handle(): iterable
    {
        try {
            return $this->supplierTransformer->handle();
        } catch (Throwable $e) {
            if (str_contains($e->getMessage(), 'Undefined array key')) {
                throw new SupplierDataHasChangedException($this->getName(), previous: $e);
            }

            throw $e;
        }
    }

    public function getName(): string
    {
        return $this->supplierTransformer->getName();
    }
}
