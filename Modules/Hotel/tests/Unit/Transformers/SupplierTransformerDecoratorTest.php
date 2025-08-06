<?php

declare(strict_types=1);

use Modules\Hotel\Exceptions\SupplierDataHasChangedException;
use Modules\Hotel\Fakers\FakeChangingTransformer;
use Modules\Hotel\Fakers\FakeOtherErrorTransformer;
use Modules\Hotel\Transformers\Decorator\SupplierTransformerDecorator;

it('throws SupplierDataHasChangedException when underlying transformer error indicates schema change', function (): void {
    $decorated = new SupplierTransformerDecorator(new FakeChangingTransformer());

    expect(fn () => collect($decorated->handle())->all())
        ->toThrow(SupplierDataHasChangedException::class);
});

it('bubbles non-schema errors as-is from transformer', function (): void {
    $decorated = new SupplierTransformerDecorator(new FakeOtherErrorTransformer());

    expect(fn () => collect($decorated->handle())->all())
        ->toThrow(\RuntimeException::class);
});
