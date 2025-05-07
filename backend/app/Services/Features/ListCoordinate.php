<?php

namespace App\Services\Features;

use App\Rulesets\BasePaginationRuleset;
use App\Services\CoordinateService;
use App\Transformers\CoordinateItemTransformer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class ListCoordinate
{
    public function __construct(
        public BasePaginationRuleset $ruleset,
        public CoordinateService $coordinateService,
        public CoordinateItemTransformer $coordinateItemTransformer,
    ) {}

    /**
     * @param array $data
     *
     * @return LengthAwarePaginator
     */
    public function handle(array $data): LengthAwarePaginator
    {
        Validator::make($data, $this->ruleset->getRuleset())->validate();
        $data = $this->coordinateService->getList($data['page'] ?? null, $data['limit'] ?? null);
        return $data;
    }
}
