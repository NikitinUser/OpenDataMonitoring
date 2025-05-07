<?php

namespace App\Dto;

/**
 * @OA\Schema(
 *  schema="CoordinateItem",
 *  type="object",
 *  required={"place_name","lat","lon","id","created_at","updated_at"},
 *  @OA\Property(property="place_name", type="string"),
 *  @OA\Property(property="lat", type="number", format="float"),
 *  @OA\Property(property="lon", type="number", format="float"),
 *  @OA\Property(property="id", type="integer"),
 *  @OA\Property(property="created_at", ref="#/components/schemas/typeTimestampNullable"),
 *  @OA\Property(property="updated_at", ref="#/components/schemas/typeTimestampNullable"),
 * )
 */
readonly class CoordinateItemDto
{
    public function __construct(
        public ?string $place_name = null,
        public ?float $lat = null,
        public ?float $lon = null,
        public ?int $id = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {
    }
}
