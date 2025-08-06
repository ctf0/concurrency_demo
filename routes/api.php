<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Hotel\Http\Controllers\Api\HotelSearchController;

Route::get('hotels/search', HotelSearchController::class)->name('api.hotels.search');
