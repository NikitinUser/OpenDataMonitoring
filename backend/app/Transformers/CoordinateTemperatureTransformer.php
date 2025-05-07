<?php

namespace App\Transformers;

use App\Dto\CoordinateTemperatureItemDto;
use App\Models\CoordinateTemperature;

class CoordinateTemperatureTransformer
{
    /**
     * @param array $item
     *
     * @return CoordinateTemperatureItemDto
     */
    public function fromArray(array $item): CoordinateTemperatureItemDto
    {
        return new CoordinateTemperatureItemDto(
            coordinate_id: $item["coordinate_id"],
            temp_cels: $item["temp_cels"],
            temp_datetime: $item["temp_datetime"],
            source: $item["source"],
            id: $item["id"] ?? null,
            created_at: $item["created_at"] ?? null,
            updated_at: $item["updated_at"] ?? null,
        );
    }

    /**
     * @param ?CoordinateTemperature $model
     *
     * @return CoordinateTemperatureItemDto
     */
    public function fromModel(?CoordinateTemperature $model): CoordinateTemperatureItemDto
    {
        return new CoordinateTemperatureItemDto(
            coordinate_id: $model?->coordinate_id,
            temp_cels: $model?->temp_cels,
            temp_datetime: $model?->temp_datetime,
            source: $model?->source,
            id: $model?->id,
            created_at: $model?->created_at,
            updated_at: $model?->updated_at,
        );
    }
}
