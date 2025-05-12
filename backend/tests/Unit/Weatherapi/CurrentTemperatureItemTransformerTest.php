<?php

namespace Tests\Unit\Weatherapi;

use App\Sdk\Weatherapi\Dto\WeatherapiResponseDto;
use App\Sdk\Weatherapi\Transformers\CurrentTemperatureItemTransformer;
use Http;
use Tests\TestCase;
use Illuminate\Http\Client\Request;

class CurrentTemperatureItemTransformerTest extends TestCase
{
    public function testTransformFromSuccessResponseSuccess(): void
    {
        Http::fake(function (Request $request) {
            return Http::response(
                file_get_contents(__DIR__.'/../../TestData/Weatherapi/weather_location_cels_success.json'),
                200
            );
        });

        $response = Http::get('');

        $transformer = app()->make(CurrentTemperatureItemTransformer::class);

        $dto = $transformer->transform($response);

        $this->assertInstanceOf(WeatherapiResponseDto::class, $dto);

        $this->assertEquals(200, $dto->statusCode);
        $this->assertEquals(4.0, $dto->temperatureCells);
        $this->assertEquals(55.752, $dto->lat);
        $this->assertEquals(37.616, $dto->lon);
        $this->assertEquals('2025-04-26 20:15:00', $dto->date);
        $this->assertEquals(null, $dto->message);
    }

    public function testTransformFromFailedResponseSuccess(): void
    {
        Http::fake(function (Request $request) {
            return Http::response(
                file_get_contents(__DIR__.'/../../TestData/Weatherapi/weather_location_cels_error.json'),
                401
            );
        });

        $response = Http::get('');

        $transformer = app()->make(CurrentTemperatureItemTransformer::class);

        $dto = $transformer->transform($response);

        $this->assertInstanceOf(WeatherapiResponseDto::class, $dto);

        $this->assertEquals(401, $dto->statusCode);
        $this->assertEquals(null, $dto->temperatureCells);
        $this->assertEquals(null, $dto->lat);
        $this->assertEquals(null, $dto->lon);
        $this->assertEquals(null, $dto->date);
        $this->assertEquals('API key has been disabled.', $dto->message);
    }
}
