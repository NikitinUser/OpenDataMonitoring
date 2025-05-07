<?php

namespace App\Rulesets;

use App\Rulesets\BodyCoordinateRuleset;
use App\Rulesets\PrimaryKeyCoordinateRuleset;

class CoordinateRuleset
{
    public function __construct(
        public BodyCoordinateRuleset $bodyRuleset,
        public PrimaryKeyCoordinateRuleset $pkRuleset,
    ) {}

    public function getRuleset()
    {
        return array_merge($this->bodyRuleset->getRuleset(), $this->pkRuleset->getRuleset());
    }
}
