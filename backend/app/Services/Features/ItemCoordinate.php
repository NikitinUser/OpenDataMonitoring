<?php

namespace App\Services\Features;

use App\Dto\CoordinateItemDto;
use App\Rulesets\PrimaryKeyCoordinateRuleset;
use App\Services\CoordinateService;
use App\Transformers\CoordinateItemTransformer;
use Illuminate\Support\Facades\Validator;

class ItemCoordinate
{
    public function __construct(
        private PrimaryKeyCoordinateRuleset $ruleset,
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
        $model = $this->coordinateService->getById($data['id']);
        $responseDto = $this->coordinateItemTransformer->fromModel($model);
        return $responseDto;
    }
}
