<?php

namespace App\Services\Features;

use App\Rulesets\BasePaginationRuleset;
use App\Services\CoordinateService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class ListCoordinate
{
    public function __construct(
        private BasePaginationRuleset $ruleset,
        private CoordinateService $coordinateService,
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
