<?php

declare(strict_types=1);

namespace Modules\Hotel\Services;

use Illuminate\Support\Enumerable;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\Log;
use Modules\Hotel\DTO\Hotel;
use Modules\Hotel\Exceptions\SupplierBaseException;
use Modules\Hotel\Exceptions\SupplierDataAggregatorException;
use Modules\Hotel\Transformers\Contract\SupplierTransformer;
use Throwable;

use function get_class;

final class SuppliersDataAggregator
{
    /**
     * @var iterable<SupplierTransformer>
     */
    private iterable $suppliers;

    public function __construct(
        SupplierTransformer ...$suppliers,
    ) {
        $this->suppliers = $suppliers;
    }

    /**
     * @throws SupplierDataAggregatorException
     */
    public function handle(): Enumerable
    {
        $class_name = get_class($this);

        try {
            $results = Concurrency::run(
                collect($this->suppliers)
                    ->map(function ($supplier) use ($class_name) {
                        return function () use ($supplier, $class_name) {
                            try {
                                return [
                                    'supplier' => $supplier->getName(),
                                    'hotels' => $supplier->handle(),
                                    'success' => true,
                                ];
                            } catch (Throwable $e) {
                                if (! $e instanceof SupplierBaseException) {
                                    Log::error($e->getMessage(), [
                                        'caller' => $class_name,
                                        'exception' => get_class($e),
                                        'trace' => $e->getTraceAsString(),
                                    ]);
                                }

                                return [
                                    'success' => false,
                                ];
                            }
                        };
                    })
                    ->toArray()
            );

            return collect($results)
                ->lazy()
                ->where('success', true)
                ->flatMap(fn (array $result) => $result['hotels'])
                ->keyBy(fn (Hotel $hotel) => $hotel->uuid);
        } catch (Throwable $e) {
            throw new SupplierDataAggregatorException(previous: $e);
        }
    }
}
