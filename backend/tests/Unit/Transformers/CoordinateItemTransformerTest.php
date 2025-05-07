<?php

namespace Tests\Unit\Transformers;

use App\Dto\CoordinateItemDto;
use App\Models\Coordinate;
use App\Transformers\CoordinateItemTransformer;
use Carbon\Carbon;
use Tests\TestCase;

class CoordinateItemTransformerTest extends TestCase
{
    private CoordinateItemTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new CoordinateItemTransformer();
    }

    public function testFromArrayWithAllFields()
    {
        $data = [
            'id' => 10,
            'place_name' => 'TestPlace',
            'lat' => 45.123456,
            'lon' => -73.654321,
            'created_at' => Carbon::parse('2023-01-01 12:00:00'),
            'updated_at' => Carbon::parse('2023-01-02 13:00:00'),
        ];

        $dto = $this->transformer->fromArray($data);

        $this->assertInstanceOf(CoordinateItemDto::class, $dto);
        $this->assertSame($data['id'], $dto->id);
        $this->assertSame($data['place_name'], $dto->place_name);
        $this->assertSame($data['lat'], $dto->lat);
        $this->assertSame($data['lon'], $dto->lon);
        $this->assertEquals($data['created_at'], $dto->created_at);
        $this->assertEquals($data['updated_at'], $dto->updated_at);
    }

    public function testFromArrayWithOnlyRequiredFields()
    {
        $data = [
            'place_name' => 'TestPlace',
            'lat' => 45.0,
            'lon' => -73.0,
        ];

        $dto = $this->transformer->fromArray($data);

        $this->assertInstanceOf(CoordinateItemDto::class, $dto);
        $this->assertNull($dto->id);
        $this->assertNull($dto->created_at);
        $this->assertNull($dto->updated_at);
    }

    public function testFromModelWithAllFields()
    {
        $model = new Coordinate();
        $model->id = 20;
        $model->place_name = 'FromModel';
        $model->lat = 50.123456;
        $model->lon = -70.654321;
        $model->created_at = Carbon::parse('2023-02-01 14:00:00');
        $model->updated_at = Carbon::parse('2023-02-02 15:00:00');

        $dto = $this->transformer->fromModel($model);

        $this->assertInstanceOf(CoordinateItemDto::class, $dto);
        $this->assertSame($model->id, $dto->id);
        $this->assertSame($model->place_name, $dto->place_name);
        $this->assertSame($model->lat, $dto->lat);
        $this->assertSame($model->lon, $dto->lon);
        $this->assertEquals($model->created_at, $dto->created_at);
        $this->assertEquals($model->updated_at, $dto->updated_at);
    }

    public function testFromModelNull()
    {
        $dto = $this->transformer->fromModel(null);

        $this->assertInstanceOf(CoordinateItemDto::class, $dto);
        $this->assertNull($dto->id);
        $this->assertNull($dto->place_name);
        $this->assertNull($dto->lat);
        $this->assertNull($dto->lon);
        $this->assertNull($dto->created_at);
        $this->assertNull($dto->updated_at);
    }
}
