<?php

namespace App\Sdk\Weatherapi\Dto;

readonly class WeatherapiResponseDto
{
    public function __construct(
        public int $statusCode,
        public string $rawContent,
        public ?string $message = null,
        public ?float $lat = null,
        public ?float $lon = null,
        public ?string $date = null,
        public ?float $temperatureCells = null,
    ) {
    }
}
