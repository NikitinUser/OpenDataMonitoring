<?php

namespace Tests\Feature\Coordinates;

use App\Models\Coordinate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\AuthTrait;
use Tests\TestCase;

class CoordinatesApiTest extends TestCase
{
    use RefreshDatabase;
    use AuthTrait;

    private function createUserAndGetToken(): string
    {
        $responseLogin = $this->sendLogin(self::LOGIN, self::PASS);
        $token = $responseLogin->json('data.token');
        return $token;
    }

    public function testCanGetCoordinatesList()
    {
        $coordinate = Coordinate::factory()->create();
        $token = $this->createUserAndGetToken();

        $response = $this->withToken($token)->getJson('/api/coordinates');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'place_name' => $coordinate->place_name,
            'lat' => $coordinate->lat,
            'lon' => $coordinate->lon,
        ]);
    }

    public function testCanStoreNewCoordinate()
    {
        $data = [
            'place_name' => 'TestPlace',
            'lat' => 45.0,
            'lon' => 45.0,
        ];
        $token = $this->createUserAndGetToken();

        $response = $this->withToken($token)->postJson('/api/coordinates', $data);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'place_name' => $data['place_name'],
            'lat' => $data['lat'],
            'lon' => $data['lon'],
        ]);
    }

    public function testCanGetSingleCoordinate()
    {
        $coordinate = Coordinate::factory()->create();
        $token = $this->createUserAndGetToken();

        $response = $this->withToken($token)->getJson("/api/coordinates/{$coordinate->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'place_name' => $coordinate->place_name,
            'lat' => $coordinate->lat,
            'lon' => $coordinate->lon,
        ]);
    }

    public function testCanUpdateCoordinate()
    {
        $coordinate = Coordinate::factory()->create();
        $data = [
            'place_name' => 'UpdatedPlace',
            'lat' => 46.0,
            'lon' => 46.0,
        ];
        $token = $this->createUserAndGetToken();

        $response = $this->withToken($token)->putJson("/api/coordinates/{$coordinate->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'place_name' => $data['place_name'],
            'lat' => $data['lat'],
            'lon' => $data['lon'],
        ]);
    }

    public function testCanDeleteCoordinate()
    {
        $coordinate = Coordinate::factory()->create();
        $token = $this->createUserAndGetToken();

        $response = $this->withToken($token)->deleteJson("/api/coordinates/{$coordinate->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('coordinates', [
            'id' => $coordinate->id,
        ]);
    }
}
