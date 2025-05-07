<?php

namespace Tests\Feature\Coordinates;


use App\Dto\CoordinateItemDto;
use App\Models\Coordinate;
use App\Services\CoordinateService;
use App\Services\Features\DeletingCoordinate;
use App\Services\Features\ItemCoordinate;
use App\Services\Features\ListCoordinate;
use App\Services\Features\NewCoordinate;
use App\Services\Features\UpdatingCoordinate;
use App\Transformers\CoordinateItemTransformer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CoordinatesFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function testNewCoordinateHandlesAndReturnsDto()
    {
        $data = [
            'place_name' => 'NewPlace',
            'lat' => 45.123456,
            'lon' => -73.654321,
        ];

        $handler = new NewCoordinate(
            ruleset: app()->make(\App\Rulesets\BodyCoordinateRuleset::class),
            coordinateService: app()->make(CoordinateService::class),
            coordinateItemTransformer: app()->make(CoordinateItemTransformer::class)
        );

        $result = $handler->handle($data);

        $this->assertInstanceOf(CoordinateItemDto::class, $result);
        $this->assertDatabaseHas('coordinates', ['place_name' => 'NewPlace']);
    }

    public function testItemCoordinateReturnsDto()
    {
        $coordinate = Coordinate::factory()->create();

        $handler = new ItemCoordinate(
            ruleset: app()->make(\App\Rulesets\PrimaryKeyCoordinateRuleset::class),
            coordinateService: app()->make(CoordinateService::class),
            coordinateItemTransformer: app()->make(CoordinateItemTransformer::class)
        );

        $result = $handler->handle(['id' => $coordinate->id]);

        $this->assertInstanceOf(CoordinateItemDto::class, $result);
        $this->assertSame($coordinate->id, $result->id);
    }

    public function testUpdatingCoordinateUpdatesAndReturnsDto()
    {
        $coordinate = Coordinate::factory()->create([
            'place_name' => 'OldName',
            'lat' => 10,
            'lon' => 20,
        ]);

        $data = [
            'id' => $coordinate->id,
            'place_name' => 'UpdatedName',
            'lat' => 11,
            'lon' => 21,
        ];

        $handler = new UpdatingCoordinate(
            ruleset: app()->make(\App\Rulesets\CoordinateRuleset::class),
            coordinateService: app()->make(CoordinateService::class),
            coordinateItemTransformer: app()->make(CoordinateItemTransformer::class)
        );

        $result = $handler->handle($data);

        $this->assertInstanceOf(CoordinateItemDto::class, $result);
        $this->assertSame('UpdatedName', $result->place_name);
        $this->assertDatabaseHas('coordinates', [
            'id' => $coordinate->id,
            'place_name' => 'UpdatedName',
        ]);
    }

    public function testDeletingCoordinateCallsDelete()
    {
        $coordinate = Coordinate::factory()->create();

        $handler = new DeletingCoordinate(
            ruleset: app()->make(\App\Rulesets\PrimaryKeyCoordinateRuleset::class),
            coordinateService: app()->make(CoordinateService::class)
        );

        $handler->handle(['id' => $coordinate->id]);

        $this->assertDatabaseMissing('coordinates', ['id' => $coordinate->id]);
    }

    public function testListCoordinateReturnsPaginator()
    {
        Coordinate::factory()->count(5)->create();

        $handler = new ListCoordinate(
            ruleset: app()->make(\App\Rulesets\BasePaginationRuleset::class),
            coordinateService: app()->make(CoordinateService::class),
            coordinateItemTransformer: app()->make(CoordinateItemTransformer::class)
        );

        $result = $handler->handle(['page' => 1, 'limit' => 2]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount(2, $result->items());
    }
}
