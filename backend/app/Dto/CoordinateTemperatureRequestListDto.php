<?php

namespace App\Dto;

readonly class CoordinateTemperatureRequestListDto
{
    /**
     * @param ?string $temp_datetime
     * @param ?float $lat
     * @param ?float $lon
     * @param ?string $source
     */
    public function __construct(
        public ?string $temp_datetime,
        public ?float $lat,
        public ?float $lon,
        public ?string $source,
    ) {}
}
