<?php

namespace App\Rulesets;

use App\Rules\RequireIntegerExistsPrimaryKeyRule;

class PrimaryKeyCoordinateRuleset
{
    public function getRuleset()
    {
        return [
            'id' => (new RequireIntegerExistsPrimaryKeyRule())->rules(),
        ];
    }
}
