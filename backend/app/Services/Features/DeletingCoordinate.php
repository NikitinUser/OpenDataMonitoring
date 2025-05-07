<?php

namespace App\Services\Features;

use App\Rulesets\PrimaryKeyCoordinateRuleset;
use App\Services\CoordinateService;
use Illuminate\Support\Facades\Validator;

class DeletingCoordinate
{
    public function __construct(
        public PrimaryKeyCoordinateRuleset $ruleset,
        public CoordinateService $coordinateService,
    ) {}

    /**
     * @param array $data
     *
     * @return void
     */
    public function handle(array $data): void
    {
        Validator::make($data, $this->ruleset->getRuleset())->validate();
        $this->coordinateService->delete($data['id']);
    }
}
