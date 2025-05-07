<?php

namespace Tests\Unit\Rulests;

use App\Rulesets\BasePaginationRuleset;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class BasePaginationRulesetTest extends TestCase
{
    private array $ruleset;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ruleset = app()->make(BasePaginationRuleset::class)->getRuleset();
    }

    private function validate(array $data): bool
    {
        return Validator::make($data, $this->ruleset)->passes();
    }

    public function testPageNotSetAndLimitNotSet()
    {
        $this->assertTrue($this->validate([]));
    }

    public function testPageSetAndValidLimitNotSet()
    {
        $this->assertTrue($this->validate(['page' => 5]));
    }

    public function testPageNotSetLimitSetAndValid()
    {
        $this->assertTrue($this->validate(['limit' => 10]));
    }

    public function testPageSetAndValidLimitSetAndValid()
    {
        $this->assertTrue($this->validate(['page' => 3, 'limit' => 25]));
    }

    public function testPageSetAsStringLimitNotSet()
    {
        $this->assertFalse($this->validate(['page' => 'abc']));
    }

    public function testPageSetAsFloatLimitNotSet()
    {
        $this->assertFalse($this->validate(['page' => 1.5]));
    }

    public function testPageSetAsNullLimitNotSet()
    {
        $this->assertFalse($this->validate(['page' => null]));
    }

    public function testPageSetAsTooLowLimitNotSet()
    {
        $this->assertFalse($this->validate(['page' => 0]));
    }

    public function testPageSetAsTooHighLimitNotSet()
    {
        $this->assertFalse($this->validate(['page' => 2147483647]));
    }

    public function testLimitSetAsStringPageNotSet()
    {
        $this->assertFalse($this->validate(['limit' => 'abc']));
    }

    public function testLimitSetAsFloatPageNotSet()
    {
        $this->assertFalse($this->validate(['limit' => 5.5]));
    }

    public function testLimitSetAsNullPageNotSet()
    {
        $this->assertFalse($this->validate(['limit' => null]));
    }

    public function testLimitSetAsTooLowPageNotSet()
    {
        $this->assertFalse($this->validate(['limit' => 0]));
    }

    public function testLimitSetAsTooHighPageNotSet()
    {
        $this->assertFalse($this->validate(['limit' => 51]));
    }
}
