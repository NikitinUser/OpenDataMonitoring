<?php

namespace Tests\Feature\Temperature;

use App\Dto\CoordinateItemDto;
use App\Jobs\CurrentWeatherJob;
use App\Models\Coordinate;
use App\Services\Features\MeteomaticsCurrentTemp;
use App\Services\Features\WeatherapiCurrentTemp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CurrentWeatherJobTest extends TestCase
{
    use RefreshDatabase;

    public function testWeatherapiJobDispatchesAndHandlesSuccessfully(): void
    {
        $coordinate = Coordinate::firstOrCreate(Coordinate::factory()->raw());
        $dto = new CoordinateItemDto(
            id: $coordinate->id,
            lat: $coordinate->lat,
            lon: $coordinate->lon,
            place_name: $coordinate->place_name
        );

        Http::fake([
            '*' => Http::response(
                file_get_contents(base_path('tests/TestData/Weatherapi/weather_location_cels_success.json')),
                200
            )
        ]);

        $job = new CurrentWeatherJob($dto, app()->make(WeatherapiCurrentTemp::class));
        $job->handle();

        $this->assertTrue(true);
    }

    public function testMeteomaticsJobDispatchesAndHandlesSuccessfully(): void
    {
        $coordinate = Coordinate::firstOrCreate(Coordinate::factory()->raw());
        $dto = new CoordinateItemDto(
            id: $coordinate->id,
            lat: $coordinate->lat,
            lon: $coordinate->lon,
            place_name: $coordinate->place_name
        );

        Http::fake([
            '*' => Http::response(
                file_get_contents(base_path('tests/TestData/Meteomatics/weather_location_cels_success.json')),
                200
            )
        ]);

        $job = new CurrentWeatherJob($dto, app()->make(MeteomaticsCurrentTemp::class));
        $job->handle();

        $this->assertTrue(true);
    }

    public function testWeatherapiJobHandlesFailedResponseGracefully(): void
    {
        $coordinate = Coordinate::firstOrCreate(Coordinate::factory()->raw());
        $dto = new CoordinateItemDto(
            id: $coordinate->id,
            lat: $coordinate->lat,
            lon: $coordinate->lon,
            place_name: $coordinate->place_name
        );

        Http::fake([
            '*' => Http::response(
                file_get_contents(base_path('tests/TestData/Weatherapi/weather_location_cels_error.json')),
                401
            )
        ]);

        $job = new CurrentWeatherJob($dto, app()->make(WeatherapiCurrentTemp::class));
        $job->handle();

        $this->assertTrue(true);
    }

    public function testMeteomaticsJobHandlesFailedResponseGracefully(): void
    {
        $coordinate = Coordinate::firstOrCreate(Coordinate::factory()->raw());
        $dto = new CoordinateItemDto(
            id: $coordinate->id,
            lat: $coordinate->lat,
            lon: $coordinate->lon,
            place_name: $coordinate->place_name
        );

        Http::fake([
            '*' => Http::response(
                file_get_contents(base_path('tests/TestData/Meteomatics/weather_location_cels_error.txt')),
                401
            )
        ]);

        $job = new CurrentWeatherJob($dto, app()->make(MeteomaticsCurrentTemp::class));
        $job->handle();

        $this->assertTrue(true);
    }
}
