<?php

namespace App\Rulesets;

use App\Rulesets\BasePaginationRuleset;
use App\Rules\DateRule;
use App\Rules\FloatFromMinToMaxRule;
use App\Rules\StringEnglishLength;

class ListCoordinateTemperatureRuleset extends BasePaginationRuleset
{
    public function getRuleset()
    {
        $parentRuleset = parent::getRuleset();

        return array_merge($parentRuleset, [
            'temp_datetime' => (new DateRule())->rules(),
            'lat' => (new FloatFromMinToMaxRule(-90, 90))->rules(),
            'lon' => (new FloatFromMinToMaxRule(-180, 180))->rules(),
            'source' => (new StringEnglishLength(1, 256))->rules(),
        ]);
    }
}
