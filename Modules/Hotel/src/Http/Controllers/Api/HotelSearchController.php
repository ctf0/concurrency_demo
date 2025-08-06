<?php

declare(strict_types=1);

namespace Modules\Hotel\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Hotel\DTO\HotelFilterCriteria;
use Modules\Hotel\Http\Actions\HotelSearch;
use Modules\Hotel\Http\Requests\HotelSearchRequest;

final class HotelSearchController extends Controller
{
    public function __invoke(HotelSearchRequest $request, HotelSearch $hotelSearch): JsonResponse
    {
        $hotels = $hotelSearch->handle(HotelFilterCriteria::fromRequest($request));

        return response()->json([
            'total' => $hotels->count(),
            'data' => $hotels->all(),
        ]);
    }
}
