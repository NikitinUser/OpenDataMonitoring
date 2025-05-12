<?php

namespace Tests\Unit\Rulests;

use App\Rulesets\BodyCoordinateTemperatureRuleset;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class BodyCoordinateTemperatureRulesetTest extends TestCase
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

        $this->ruleset = app()->make(BodyCoordinateTemperatureRuleset::class)->getRuleset();
    }

    private function validate(array $data): bool
    {
        return Validator::make($data, $this->ruleset)->passes();
    }

    public function testValidDataPassesValidation(): void
    {
        $data = [
            'coordinate_id' => 1,
            'temp_cels' => 36.6,
            'temp_datetime' => '2024-05-10 12:00:00',
            'source' => 'Test Source',
        ];

        $this->assertTrue($this->validate($data));
    }

    public function testCoordinateIdIsRequiredAndMustExist(): void
    {
        $data = [
            'temp_cels' => 36.6,
            'temp_datetime' => '2024-01-01 12:00:00',
            'source' => 'Valid Source',
        ];
        $this->assertFalse($this->validate($data));

        $data['coordinate_id'] = 'abc';
        $this->assertFalse($this->validate($data));
    }

    public function testTempCelsValidation(): void
    {
        $data = [
            'coordinate_id' => 1,
            'temp_datetime' => '2024-01-01 12:00:00',
            'source' => 'Valid Source',
        ];
        $this->assertFalse($this->validate($data));

        $data['temp_cels'] = -91;
        $this->assertFalse($this->validate($data));

        $data['temp_cels'] = 91;
        $this->assertFalse($this->validate($data));

        $data['temp_cels'] = 36.1234567;
        $this->assertFalse($this->validate($data));

        $data['temp_cels'] = 36.123456;
        $this->assertTrue($this->validate($data));
    }

    public function testTempDatetimeValidation(): void
    {
        $data = [
            'coordinate_id' => 1,
            'temp_cels' => 36.6,
            'source' => 'Valid Source',
        ];
        $this->assertFalse($this->validate($data));

        $data['temp_datetime'] = '01-01-2024 12:00:00';
        $this->assertFalse($this->validate($data));

        $data['temp_datetime'] = '2024-01-01 12:00:00';
        $this->assertTrue($this->validate($data));
    }

    public function testSourceValidation(): void
    {
        $data = [
            'coordinate_id' => 1,
            'temp_cels' => 36.6,
            'temp_datetime' => '2024-01-01 12:00:00',
        ];
        $this->assertFalse($this->validate($data));

        $data['source'] = '';
        $this->assertFalse($this->validate($data));

        $data['source'] = str_repeat('a', 257);
        $this->assertFalse($this->validate($data));

        $data['source'] = 'Invalid123!';
        $this->assertFalse($this->validate($data));

        $data['source'] = 'Valid Source';
        $this->assertTrue($this->validate($data));
    }
}
