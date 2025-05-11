<?php

namespace App\Services\Features;

use App\Dto\CoordinateItemDto;
use App\Rulesets\CoordinateRuleset;
use App\Services\CoordinateService;
use App\Transformers\CoordinateItemTransformer;
use Illuminate\Support\Facades\Validator;

class UpdatingCoordinate
{
    public function __construct(
        private CoordinateRuleset $ruleset,
        private CoordinateService $coordinateService,
        private CoordinateItemTransformer $coordinateItemTransformer,
    ) {}

    /**
     * @param array $data
     *
     * @return CoordinateItemDto
     */
    public function handle(array $data): CoordinateItemDto
    {
        Validator::make($data, $this->ruleset->getRuleset())->validate();
        $requestDto = $this->coordinateItemTransformer->fromArray($data);
        $model = $this->coordinateService->update($requestDto);
        $responseDto = $this->coordinateItemTransformer->fromModel($model);
        return $responseDto;
    }
}
