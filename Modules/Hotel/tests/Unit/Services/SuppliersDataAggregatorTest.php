<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Concurrency;
use Modules\Hotel\Fakers\FakeSupplierAClient;
use Modules\Hotel\Fakers\FakeSupplierBClient;
use Modules\Hotel\Fakers\TransformerA;
use Modules\Hotel\Fakers\TransformerB;
use Modules\Hotel\Services\SuppliersDataAggregator;
use Modules\Hotel\Transformers\SupplierATransformer;
use Modules\Hotel\Transformers\SupplierBTransformer;

it('aggregates hotels from multiple transformers', function (): void {
    $t1 = new SupplierATransformer(new FakeSupplierAClient());
    $t2 = new SupplierBTransformer(new FakeSupplierBClient());

    Concurrency::shouldReceive('run')->andReturn([
        [
            'supplier' => 'A',
            'hotels' => [$t1->handle()->first()],
            'success' => true,
        ],
        [
            'supplier' => 'B',
            'hotels' => [$t2->handle()->last()],
            'success' => true,
        ],
    ]);

    $agg = new SuppliersDataAggregator($t1, $t2);
    $results = $agg->handle();

    expect($results->count())->toBe(2);
    expect($results->values()->pluck('name')->all())->toEqualCanonicalizing(['Hilton', 'Sheraton']);
});

it('aggregator mark failed suppliers and continues without throwing', function (): void {
    $ok = new TransformerA();
    $bad = new TransformerB();

    Concurrency::shouldReceive('run')->andReturn([
        ['supplier' => $ok->getName(), 'hotels' => $ok->handle(), 'success' => true],
    ]);

    $agg = new SuppliersDataAggregator($ok, $bad);
    $out = $agg->handle();

    expect($out->count())->toBe(2);
});
