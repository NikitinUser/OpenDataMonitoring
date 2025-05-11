<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\Coordinate;
use Illuminate\Database\Seeder;

class CoordinateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coordinates')->insertOrIgnore([
            'id' => 1,
            'place_name' => 'Moscow',
            'lat' => 55.751244,
            'lon' => 37.618423,
        ]);

        Coordinate::factory()
            ->count(1)
            ->create();
    }
}
