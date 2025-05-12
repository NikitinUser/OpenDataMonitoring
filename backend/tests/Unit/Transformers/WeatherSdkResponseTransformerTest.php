<?php

namespace Tests\Unit\Transformers;

use App\Dto\CoordinateItemDto;
use App\Sdk\Meteomatics\Dto\MeteomaticsResponseDto;
use App\Sdk\Weatherapi\Dto\WeatherapiResponseDto;
use App\Transformers\WeatherSdkResponseTransformer;
use Tests\TestCase;

class WeatherSdkResponseTransformerTest extends TestCase
{
    private WeatherSdkResponseTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new WeatherSdkResponseTransformer();
    }

    public function testToSaveFromWeatherapiTransformsCorrectly(): void
    {
        $weatherDto = new WeatherapiResponseDto(
            statusCode: 200,
            rawContent: '{}',
            message: null,
            lat: 52.1,
            lon: 21.0,
            date: '2024-05-10 12:00:00',
            temperatureCells: 17.5
        );

        $coordinateDto = new CoordinateItemDto(
            id: 42,
            lat: 52.1,
            lon: 21.0,
            place_name: 'Test City'
        );

        $result = $this->transformer->toSaveFromWeatherapi($weatherDto, $coordinateDto);

        $this->assertSame([
            'coordinate_id' => 42,
            'temp_cels' => 17.5,
            'temp_datetime' => '2024-05-10 12:00:00',
            'source' => config('api.endpoints.weatherapi.name'),
        ], $result);
    }

    public function testToSaveFromMeteomaticsTransformsCorrectly(): void
    {
        $meteomaticsDto = new MeteomaticsResponseDto(
            statusCode: 200,
            rawContent: '{}',
            lat: 48.2,
            lon: 16.3,
            date: '2024-05-10 14:00:00',
            temperatureCells: 20.0
        );

        $coordinateDto = new CoordinateItemDto(
            id: 77,
            lat: 48.2,
            lon: 16.3,
            place_name: 'Vienna'
        );

        $result = $this->transformer->toSaveFromMeteomatics($meteomaticsDto, $coordinateDto);

        $this->assertSame([
            'coordinate_id' => 77,
            'temp_cels' => 20.0,
            'temp_datetime' => '2024-05-10 14:00:00',
            'source' => config('api.endpoints.meteomatics.name'),
        ], $result);
    }
}
