<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CheckForApiHeaderExistence
{
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if (! $request->headers->contains('accept', 'application/json')) {
            abort(JsonResponse::HTTP_BAD_REQUEST, 'missing (accept : application/json header)');
        }

        return $next($request);
    }
}
