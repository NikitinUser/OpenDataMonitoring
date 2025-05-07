<?php

namespace Database\Factories;

use App\Models\Coordinate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoordinateFactory extends Factory
{
    protected $model = Coordinate::class;

    public function definition()
    {
        return [
            'place_name' => $this->faker->word,
            'lat' => $this->faker->latitude(-90, 90),
            'lon' => $this->faker->longitude(-180, 180),
        ];
    }
}
