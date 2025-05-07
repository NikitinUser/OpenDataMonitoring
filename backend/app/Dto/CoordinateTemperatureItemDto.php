<?php

namespace App\Dto;

/**
 * @OA\Schema(
 *  schema="CoordinateTemperatureItem",
 *  type="object",
 *  required={"coordinate_id","temp_cels","temp_datetime","source","id","created_at","updated_at"},
 *  @OA\Property(property="coordinate_id", type="integr"),
 *  @OA\Property(property="temp_cels", type="number", format="float"),
 *  @OA\Property(property="temp_datetime", type="string", format="Y-m-d H:i:s"),
 * @OA\Property(property="source", type="string"),
 *  @OA\Property(property="id", type="integer"),
 *  @OA\Property(property="created_at", ref="#/components/schemas/typeTimestampNullable"),
 *  @OA\Property(property="updated_at", ref="#/components/schemas/typeTimestampNullable"),
 * )
 */
readonly class CoordinateTemperatureItemDto
{
    public function __construct(
        public ?int $coordinate_id = null,
        public ?float $temp_cels = null,
        public ?string $temp_datetime = null,
        public ?string $source = null,
        public ?int $id = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {
    }
}
