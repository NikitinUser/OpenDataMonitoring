<?php

namespace App\Rulesets;

use App\Rules\FloatFromMinToMaxRule;
use App\Rules\StringEnglishLength;

class BodyCoordinateRuleset
{
    public function getRuleset()
    {
        return [
            'place_name' => (new StringEnglishLength(1, 256, true))->rules(),
            'lat' => (new FloatFromMinToMaxRule(-90, 90, required: true))->rules(),
            'lon' => (new FloatFromMinToMaxRule(-180, 180, required: true))->rules(),
        ];
    }
}
