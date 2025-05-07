<?php

namespace App\Transformers;

use App\Dto\CoordinateItemDto;
use App\Models\Coordinate;

class CoordinateItemTransformer
{
    /**
     * @param array $item
     *
     * @return CoordinateItemDto
     */
    public function fromArray(array $item): CoordinateItemDto
    {
        return new CoordinateItemDto(
            place_name: $item["place_name"],
            lat: $item["lat"],
            lon: $item["lon"],
            id: $item["id"] ?? null,
            created_at: $item["created_at"] ?? null,
            updated_at: $item["updated_at"] ?? null,
        );
    }

    /**
     * @param ?Coordinate $model
     *
     * @return CoordinateItemDto
     */
    public function fromModel(?Coordinate $model): CoordinateItemDto
    {
        return new CoordinateItemDto(
            place_name: $model?->place_name,
            lat: $model?->lat,
            lon: $model?->lon,
            id: $model?->id,
            created_at: $model?->created_at,
            updated_at: $model?->updated_at,
        );
    }
}
