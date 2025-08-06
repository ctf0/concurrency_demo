<?php

declare(strict_types=1);

namespace Modules\Hotel\DTO;

use Illuminate\Support\Str;

final class Hotel
{
    public function __construct(
        public string $id,
        public string $uuid,
        public string $name,
        public string $location,
        public float $pricePerNight,
        public int $availableRooms,
        public float $rating,
        public string $source,
        public HotelCoordinates $coordinates,
    ) {}

    public static function fromArray(array $data): self
    {
        $data['uuid'] = Str::uuid7()->toString();
        $data['coordinates'] = HotelCoordinates::fromArray($data['coordinates'] ?? []);

        return new self(...$data);
    }

    public function getDuplicationKey(): string
    {
        $name = Str::lower($this->name);
        $location = Str::lower($this->location);

        return Str::slug("{$name}_{$location}");
    }
}
