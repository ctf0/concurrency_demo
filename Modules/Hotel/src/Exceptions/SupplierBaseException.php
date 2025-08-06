<?php

declare(strict_types=1);

namespace Modules\Hotel\Exceptions;

use Exception;
use Throwable;

abstract class SupplierBaseException extends Exception
{
    public function __construct(string $msg = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($msg, $code, $previous);
    }
}
