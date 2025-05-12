<?php

namespace App\Services\Features;

use App\Rulesets\ListCoordinateTemperatureRuleset;
use App\Services\CoordinateTemperatureService;
use App\Transformers\CoordinateTemperatureRequestListTransformer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class ListCoordinateTemperature
{
    public function __construct(
        private ListCoordinateTemperatureRuleset $ruleset,
        private CoordinateTemperatureService $coordinateTemperatureService,
        private CoordinateTemperatureRequestListTransformer $requestTransformer,
    ) {}

    /**
     * @param array $data
     *
     * @return LengthAwarePaginator
     */
    public function handle(array $data): LengthAwarePaginator
    {
        Validator::make($data, $this->ruleset->getRuleset())->validate();
        $requestDto = $this->requestTransformer->fromArray($data);
        $data = $this->coordinateTemperatureService->getList($requestDto, $data['page'] ?? null, $data['limit'] ?? null);
        return $data;
    }
}
