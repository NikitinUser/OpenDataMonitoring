<?php

namespace App\Services\Features;

use App\Dto\CoordinateItemDto;
use App\Dto\CoordinateTemperatureItemDto;
use App\Rulesets\CoordinateRuleset;
use App\Services\Features\Interfaces\CurrentTempInterface;
use App\Services\Features\NewCoordinateTemperature;
use App\Sdk\Weatherapi\WeatherapiSdk;
use App\Transformers\WeatherSdkResponseTransformer;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class WeatherapiCurrentTemp implements CurrentTempInterface
{
    public function __construct(
        private CoordinateRuleset $ruleset,
        private NewCoordinateTemperature $newCoordinateTemperatureFeatureService,
        private WeatherSdkResponseTransformer $weatherSdkResponseTransformer,
        private WeatherapiSdk $weatherapiSdk,
    ) {}

    /**
     * @param CoordinateItemDto $coordinateItemDto
     *
     * @return ?CoordinateTemperatureItemDto
     */
    public function handle(CoordinateItemDto $coordinateItemDto): ?CoordinateTemperatureItemDto
    {
        Validator::make((array) $coordinateItemDto, $this->ruleset->getRuleset())->validate();
        $sdkDto = $this->weatherapiSdk
            ->getCurrentTemperature(sprintf('%s,%s', $coordinateItemDto->lat, $coordinateItemDto->lon));

        if ($sdkDto->statusCode !== SymfonyResponse::HTTP_OK) {
            return null;
        }

        $temperatureData = $this->weatherSdkResponseTransformer->toSaveFromWeatherapi($sdkDto, $coordinateItemDto);
        $responseDto = $this->newCoordinateTemperatureFeatureService->handle($temperatureData);
        return $responseDto;
    }
}
