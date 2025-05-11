<?php

namespace App\Services\Features;

use App\Dto\CoordinateTemperatureItemDto;
use App\Rulesets\BodyCoordinateTemperatureRuleset;
use App\Services\CoordinateTemperatureService;
use App\Transformers\CoordinateTemperatureTransformer;
use Illuminate\Support\Facades\Validator;

class NewCoordinateTemperature
{
    public function __construct(
        private BodyCoordinateTemperatureRuleset $ruleset,
        private CoordinateTemperatureService $coordinateTemperatureService,
        private CoordinateTemperatureTransformer $coordinateTemperatureTransformer,
    ) {}

    /**
     * @param array $data
     *
     * @return CoordinateTemperatureItemDto
     */
    public function handle(array $data): CoordinateTemperatureItemDto
    {
        Validator::make($data, $this->ruleset->getRuleset())->validate();
        $requestDto = $this->coordinateTemperatureTransformer->fromArray($data);
        $model = $this->coordinateTemperatureService->store($requestDto);
        $responseDto = $this->coordinateTemperatureTransformer->fromModel($model);
        return $responseDto;
    }
}
