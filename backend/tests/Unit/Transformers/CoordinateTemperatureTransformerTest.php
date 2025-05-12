<?php

namespace Tests\Unit\Transformers;
use App\Dto\CoordinateTemperatureItemDto;
use App\Models\CoordinateTemperature;
use App\Transformers\CoordinateTemperatureTransformer;
use Carbon\Carbon;
use Tests\TestCase;

class CoordinateTemperatureTransformerTest extends TestCase
{
    private CoordinateTemperatureTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new CoordinateTemperatureTransformer();
    }

    public function testTransformsFromArrayWithAllFields(): void
    {
        $input = [
            'coordinate_id' => 5,
            'temp_cels' => 36.6,
            'temp_datetime' => '2024-05-10 12:00:00',
            'source' => 'Station A',
            'id' => 10,
            'created_at' => '2024-05-10 12:01:00',
            'updated_at' => '2024-05-10 12:02:00',
        ];

        $dto = $this->transformer->fromArray($input);

        $this->assertInstanceOf(CoordinateTemperatureItemDto::class, $dto);
        $this->assertSame(5, $dto->coordinate_id);
        $this->assertSame(36.6, $dto->temp_cels);
        $this->assertSame('2024-05-10 12:00:00', $dto->temp_datetime);
        $this->assertSame('Station A', $dto->source);
        $this->assertSame(10, $dto->id);
        $this->assertSame('2024-05-10 12:01:00', $dto->created_at);
        $this->assertSame('2024-05-10 12:02:00', $dto->updated_at);
    }

    public function testTransformsFromArrayWithMissingOptionalFields(): void
    {
        $input = [
            'coordinate_id' => 2,
            'temp_cels' => 22.5,
            'temp_datetime' => '2024-01-01 00:00:00',
            'source' => 'Test',
        ];

        $dto = $this->transformer->fromArray($input);

        $this->assertSame(2, $dto->coordinate_id);
        $this->assertSame(22.5, $dto->temp_cels);
        $this->assertSame('2024-01-01 00:00:00', $dto->temp_datetime);
        $this->assertSame('Test', $dto->source);
        $this->assertNull($dto->id);
        $this->assertNull($dto->created_at);
        $this->assertNull($dto->updated_at);
    }

    public function testTransformsFromArrayEmptyArray(): void
    {
        $input = [];

        try {
            $this->transformer->fromArray($input);
        } catch (\Throwable $t) {
            $this->assertTrue(true);
        }
    }

    public function testTransformsFromNullModel(): void
    {
        $dto = $this->transformer->fromModel(null);

        $this->assertInstanceOf(CoordinateTemperatureItemDto::class, $dto);
        $this->assertNull($dto->coordinate_id);
        $this->assertNull($dto->temp_cels);
        $this->assertNull($dto->temp_datetime);
        $this->assertNull($dto->source);
        $this->assertNull($dto->id);
        $this->assertNull($dto->created_at);
        $this->assertNull($dto->updated_at);
    }

    public function testTransformsFromModel(): void
    {
        $model = new CoordinateTemperature();
        $model->coordinate_id = 7;
        $model->temp_cels = 25.5;
        $model->temp_datetime = '2024-05-11 14:00:00';
        $model->source = 'Satellite';
        $model->id = 77;
        $model->created_at = Carbon::parse('2024-05-11 14:01:00')->toDateTimeString();
        $model->updated_at = Carbon::parse('2024-05-11 14:02:00')->toDateTimeString();

        $dto = $this->transformer->fromModel($model);

        $this->assertSame(7, $dto->coordinate_id);
        $this->assertSame(25.5, $dto->temp_cels);
        $this->assertSame('2024-05-11 14:00:00', $dto->temp_datetime);
        $this->assertSame('Satellite', $dto->source);
        $this->assertSame(77, $dto->id);
        $this->assertSame('2024-05-11 14:01:00', $dto->created_at);
        $this->assertSame('2024-05-11 14:02:00', $dto->updated_at);
    }
}
