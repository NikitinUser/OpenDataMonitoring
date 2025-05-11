<?php

namespace Database\Factories;

use App\Models\Coordinate;
use App\Models\CoordinateTemperature;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoordinateTemperatureFactory extends Factory
{
    protected $model = CoordinateTemperature::class;

    public function definition()
    {
        $coordinate = Coordinate::firstOrCreate(Coordinate::factory()->raw());

        return [
            'coordinate_id' => $coordinate->id,
            'temp_cels' => $this->faker->randomNumber(),
            'temp_datetime' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'source' => $this->faker->word,
        ];
    }
}
