<?php

declare(strict_types=1);

namespace Modules\Hotel\DTO;

final class HotelCoordinates
{
    public function __construct(
        public ?float $lat = null,
        public ?float $lng = null,
    ) {}

    public static function fromArray(?array $data): self
    {
        return new self(...$data);
    }
}
