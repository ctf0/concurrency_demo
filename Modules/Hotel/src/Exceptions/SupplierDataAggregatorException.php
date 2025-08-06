<?php

declare(strict_types=1);

namespace Modules\Hotel\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

use function get_class;

final class SupplierDataAggregatorException extends SupplierBaseException
{
    public function __construct(string $msg = '', int $code = Response::HTTP_INTERNAL_SERVER_ERROR, ?Throwable $previous = null)
    {
        $msg = 'Something went wrong with the supplier data aggregation process, better disable (Concurrency::run) call, so you can debug it easily';

        Log::error($msg, [
            'exception' => get_class($this),
            'previous' => $previous ? get_class($previous) : null,
            'trace' => $this->getTraceAsString(),
        ]);

        parent::__construct($msg, $code, $previous);
    }
}
