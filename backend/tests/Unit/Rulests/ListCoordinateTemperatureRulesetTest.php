<?php

namespace Tests\Unit\Rulests;

use App\Rulesets\ListCoordinateTemperatureRuleset;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ListCoordinateTemperatureRulesetTest extends TestCase
{
    private array $ruleset;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ruleset = app()->make(ListCoordinateTemperatureRuleset::class)->getRuleset();
    }

    private function validate(array $data): bool
    {
        return Validator::make($data, $this->ruleset)->passes();
    }

    public function testValidDataPassesValidation(): void
    {
        $data = [
            'temp_datetime' => '2024-01-01',
            'lat' => 45.123456,
            'lon' => 90.654321,
            'source' => 'Valid Source',
        ];

        $this->assertTrue($this->validate($data));
    }

    public function testDateValidation(): void
    {
        $data = [
            'lat' => 10.0,
            'lon' => 10.0,
            'source' => 'Some Source',
        ];
        $this->assertTrue($this->validate($data));

        $data['temp_datetime'] = '01-01-2024';
        $this->assertFalse($this->validate($data));

        $data['temp_datetime'] = '2024-05-10';
        $this->assertTrue($this->validate($data));
    }

    public function testLatitudeValidation(): void
    {
        $data = ['lat' => -91, 'lon' => 0, 'source' => 'A', 'date' => '2024-01-01'];
        $this->assertFalse($this->validate($data));

        $data['lat'] = 91;
        $this->assertFalse($this->validate($data));

        $data['lat'] = 45.1234567;
        $this->assertFalse($this->validate($data));

        $data['lat'] = 45.123456;
        $this->assertTrue($this->validate($data));
    }

    public function testLongitudeValidation(): void
    {
        $data = ['lat' => 0, 'lon' => -181, 'source' => 'A', 'date' => '2024-01-01'];
        $this->assertFalse($this->validate($data));

        $data['lon'] = 181;
        $this->assertFalse($this->validate($data));

        $data['lon'] = 90.1234567;
        $this->assertFalse($this->validate($data));

        $data['lon'] = 90.123456;
        $this->assertTrue($this->validate($data));
    }

    public function testSourceValidation(): void
    {
        $data = [
            'lat' => 10.0,
            'lon' => 10.0,
            'temp_datetime' => '2024-01-01',
        ];
        $this->assertTrue($this->validate($data));

        $data['source'] = 'Invalid123!';
        $this->assertFalse($this->validate($data));

        $data['source'] = str_repeat('a', 257);
        $this->assertFalse($this->validate($data));

        $data['source'] = 'Valid Source';
        $this->assertTrue($this->validate($data));
    }
}
