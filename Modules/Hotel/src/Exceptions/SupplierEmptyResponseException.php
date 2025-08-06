<?php

declare(strict_types=1);

namespace Modules\Hotel\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

use function get_class;

final class SupplierEmptyResponseException extends SupplierBaseException
{
    public function __construct(string $supplierName, int $code = Response::HTTP_NO_CONTENT, ?Throwable $previous = null)
    {
        $msg = "Supplier : ({$supplierName}) returned an empty response";

        Log::error($msg, [
            'exception' => get_class($this),
        ]);

        parent::__construct($msg, $code, $previous);
    }
}
