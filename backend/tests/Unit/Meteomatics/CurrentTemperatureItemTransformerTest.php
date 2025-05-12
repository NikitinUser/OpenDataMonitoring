<?php

namespace Tests\Unit\Meteomatics;

use App\Sdk\Meteomatics\Dto\MeteomaticsResponseDto;
use App\Sdk\Meteomatics\Transformers\CurrentTemperatureItemTransformer;
use Http;
use Tests\TestCase;
use Illuminate\Http\Client\Request;

class CurrentTemperatureItemTransformerTest extends TestCase
{
    public function testTransformFromSuccessResponseSuccess(): void
    {
        Http::fake(function (Request $request) {
            return Http::response(
                file_get_contents(__DIR__.'/../../TestData/Meteomatics/weather_location_cels_success.json'),
                200
            );
        });

        $response = Http::get('');

        $transformer = app()->make(CurrentTemperatureItemTransformer::class);

        $dto = $transformer->transform($response);

        $this->assertInstanceOf(MeteomaticsResponseDto::class, $dto);

        $this->assertEquals(200, $dto->statusCode);
        $this->assertEquals(3.3, $dto->temperatureCells);
        $this->assertEquals(55.751244, $dto->lat);
        $this->assertEquals(37.618423, $dto->lon);
        $this->assertEquals('2025-04-26 20:00:00', $dto->date);
    }

    public function testTransformFromFailedResponseSuccess(): void
    {
        Http::fake(function (Request $request) {
            return Http::response(
                file_get_contents(__DIR__.'/../../TestData/Meteomatics/weather_location_cels_error.txt'),
                401
            );
        });

        $response = Http::get('');

        $transformer = app()->make(CurrentTemperatureItemTransformer::class);

        $dto = $transformer->transform($response);

        $this->assertInstanceOf(MeteomaticsResponseDto::class, $dto);

        $this->assertEquals(401, $dto->statusCode);
        $this->assertEquals(null, $dto->temperatureCells);
        $this->assertEquals(null, $dto->lat);
        $this->assertEquals(null, $dto->lon);
        $this->assertEquals(null, $dto->date);
    }
}
