<?php

namespace Tests\Unit\Rulests;

use App\Rulesets\PrimaryKeyCoordinateRuleset;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PrimaryKeyCoordinateRulesetTest extends TestCase
{
    private array $ruleset;

    protected function setUp(): void
    {
        parent::setUp();

        Validator::resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new class($translator, $data, $rules, $messages, $attributes) extends \Illuminate\Validation\Validator {
                public function validateExists($attribute, $value, $parameters)
                {
                    return true;
                }
            };
        });

        $this->ruleset = app()->make(PrimaryKeyCoordinateRuleset::class)->getRuleset();
    }

    private function validate(array $data): bool
    {
        return Validator::make($data, $this->ruleset)->passes();
    }

    public function testValidId()
    {
        $this->assertTrue($this->validate(['id' => 123]));
    }

    public function testIdMissing()
    {
        $this->assertFalse($this->validate([]));
    }

    public function testIdAsString()
    {
        $this->assertFalse($this->validate(['id' => 'abc']));
    }

    public function testIdAsFloat()
    {
        $this->assertFalse($this->validate(['id' => 123.45]));
    }

    public function testIdAsNull()
    {
        $this->assertFalse($this->validate(['id' => null]));
    }
}
