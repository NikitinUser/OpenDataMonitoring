<?php

namespace Tests\Feature\Temperature;

use App\Models\Coordinate;
use App\Models\CoordinateTemperature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\Feature\AuthTrait;
use Tests\TestCase;

class CoordinateTemperatureApiTest extends TestCase
{
    use RefreshDatabase;
    use AuthTrait;

    private function createUserAndGetToken(): string
    {
        $responseLogin = $this->sendLogin(self::LOGIN, self::PASS);
        $token = $responseLogin->json('data.token');
        return $token;
    }

    public function testAuthorizedUserGetsPaginatedData(): void
    {
        $token = $this->createUserAndGetToken();

        CoordinateTemperature::factory()->count(3)->create();

        $response = $this->withToken($token)->getJson('/api/coordinates_temperature');

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'data' => [
                'current_page',
                'last_page',
                'per_page',
                'total',
                'data' => [
                    ['id', 'coordinate_id', 'temp_cels', 'temp_datetime', 'source', 'created_at', 'updated_at'],
                ]
            ]
        ]);
    }

    public function testUnauthorizedUserGets401(): void
    {
        $response = $this->getJson('/api/coordinates_temperature');

        $response->assertStatus(401);
    }

    public function testValidationFailsOnInvalidLat(): void
    {
        $token = $this->createUserAndGetToken();

        $response = $this->withToken($token)->getJson('/api/coordinates_temperature?lat=invalid');

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['lat']);
    }

    public function testFilteringBySourceAndDate(): void
    {
        $token = $this->createUserAndGetToken();
        $source = 'TestSource';
        $now = Carbon::now();
        $datetimeNow = $now->format('Y-m-d H:i:s');
        $dateNow = $now->format('Y-m-d');

        $coordinate = Coordinate::factory()->create();
        CoordinateTemperature::factory()->create([
            'coordinate_id' => $coordinate->id,
            'source' => $source,
            'temp_datetime' => $datetimeNow,
        ]);

        CoordinateTemperature::factory()->create();

        $response = $this->withToken($token)->getJson("/api/coordinates_temperature?source={$source}&date={$dateNow}");

        $response->assertOk();
        $data = $response->json('data.data');
        $this->assertCount(1, $data);
        $this->assertSame($source, $data[0]['source']);
        $this->assertSame($datetimeNow, $data[0]['temp_datetime']);
    }
}
