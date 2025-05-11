<?php

namespace App\Transformers;

use App\Dto\CoordinateItemDto;
use App\Sdk\Weatherapi\Dto\WeatherapiResponseDto;
use App\Sdk\Meteomatics\Dto\MeteomaticsResponseDto;

class WeatherSdkResponseTransformer
{
    /**
     * @param WeatherapiResponseDto $dto
     * @param CoordinateItemDto $coordinateItemDto
     *
     * @return array
     */
    public function toSaveFromWeatherapi(WeatherapiResponseDto $dto, CoordinateItemDto $coordinateItemDto): array
    {
        return [
            'coordinate_id' => $coordinateItemDto->id,
            'temp_cels' => $dto->temperatureCells,
            'temp_datetime' => $dto->date,
            'source' => config('api.endpoints.weatherapi.name'),
        ];
    }

    /**
     * @param MeteomaticsResponseDto $dto
     * @param CoordinateItemDto $coordinateItemDto
     *
     * @return array
     */
    public function toSaveFromMeteomatics(MeteomaticsResponseDto $dto, CoordinateItemDto $coordinateItemDto): array
    {
        return [
            'coordinate_id' => $coordinateItemDto->id,
            'temp_cels' => $dto->temperatureCells,
            'temp_datetime' => $dto->date,
            'source' => config('api.endpoints.meteomatics.name'),
        ];
    }
}
