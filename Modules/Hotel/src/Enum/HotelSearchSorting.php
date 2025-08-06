<?php

declare(strict_types=1);

namespace Modules\Hotel\Enum;

enum HotelSearchSorting: string
{
    case PRICE = 'price';
    case RATING = 'rating';
}
