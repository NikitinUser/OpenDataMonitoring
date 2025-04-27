<?php

namespace App\Sdk\Meteomatics\Dto;

readonly class MeteomaticsResponseDto
{
    public function __construct(
        public int $statusCode,
        public string $rawContent,
        public ?float $lat = null,
        public ?float $lon = null,
        public ?string $date = null,
        public ?float $temperatureCells = null,
    ) {
    }
}
