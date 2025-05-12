<?php

namespace App\Transformers;

use App\Dto\CoordinateTemperatureRequestListDto;

class CoordinateTemperatureRequestListTransformer
{
    /**
     * @param array $item
     *
     * @return CoordinateTemperatureRequestListDto
     */
    public function fromArray(array $item): CoordinateTemperatureRequestListDto
    {
        return new CoordinateTemperatureRequestListDto(
            temp_datetime: $item['temp_datetime'] ?? null,
            lat: $item['lat'] ?? null,
            lon: $item['lon'] ?? null,
            source: $item['source'] ?? null,
        );
    }
}
