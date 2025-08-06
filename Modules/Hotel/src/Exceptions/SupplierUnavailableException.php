<?php

declare(strict_types=1);

namespace Modules\Hotel\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

use function get_class;

final class SupplierUnavailableException extends SupplierBaseException
{
    public function __construct(string $supplierName, int $code = Response::HTTP_SERVICE_UNAVAILABLE, ?Throwable $previous = null)
    {
        $msg = "Supplier : ({$supplierName}) is currently unavailable";

        Log::error($msg, [
            'exception' => get_class($this),
            'previous' => $previous ? get_class($previous) : null,
            'trace' => $this->getTraceAsString(),
        ]);

        parent::__construct($msg, $code, $previous);
    }
}
