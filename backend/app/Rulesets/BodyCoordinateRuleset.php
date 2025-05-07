<?php

namespace App\Rulesets;

use App\Rules\RequireFloatFromMinToMaxRule;
use App\Rules\RequireStringEnglishLength;

class BodyCoordinateRuleset
{
    public function getRuleset()
    {
        return [
            'place_name' => (new RequireStringEnglishLength(1, 256))->rules(),
            'lat' => (new RequireFloatFromMinToMaxRule(-90, 90))->rules(),
            'lon' => (new RequireFloatFromMinToMaxRule(-180, 180))->rules(),
        ];
    }
}
