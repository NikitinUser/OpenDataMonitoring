<?php

namespace App\Rulesets;

use App\Rules\DateTimeRule;
use App\Rules\FloatFromMinToMaxRule;
use App\Rules\RequireIntegerExistsPrimaryKeyRule;
use App\Rules\StringEnglishLength;

class BodyCoordinateTemperatureRuleset
{
    public function getRuleset()
    {
        return [
            'coordinate_id' => (new RequireIntegerExistsPrimaryKeyRule('coordinates'))->rules(),
            'temp_cels' => (new FloatFromMinToMaxRule(-90, 90, required: true))->rules(),
            'temp_datetime' => (new DateTimeRule(required: true))->rules(),
            'source' => (new StringEnglishLength(1, 256, true))->rules(),
        ];
    }
}
