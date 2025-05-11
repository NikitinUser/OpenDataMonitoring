<?php

namespace Tests\Unit\Transformers;

use App\Dto\CoordinateTemperatureRequestListDto;
use App\Transformers\CoordinateTemperatureRequestListTransformer;
use Tests\TestCase;

class CoordinateTemperatureRequestListTransformerTest extends TestCase
{
    private CoordinateTemperatureRequestListTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new CoordinateTemperatureRequestListTransformer();
    }

    public function testTransformsCompleteArray(): void
    {
        $input = [
            'temp_datetime' => '2024-05-10',
            'lat' => 45.123456,
            'lon' => 90.654321,
            'source' => 'Test Source',
        ];

        $dto = $this->transformer->fromArray($input);

        $this->assertInstanceOf(CoordinateTemperatureRequestListDto::class, $dto);
        $this->assertSame('2024-05-10', $dto->temp_datetime);
        $this->assertSame(45.123456, $dto->lat);
        $this->assertSame(90.654321, $dto->lon);
        $this->assertSame('Test Source', $dto->source);
    }

    public function testTransformsEmptyArray(): void
    {
        $input = [];

        $dto = $this->transformer->fromArray($input);

        $this->assertNull($dto->temp_datetime);
        $this->assertNull($dto->lat);
        $this->assertNull($dto->lon);
        $this->assertNull($dto->source);
    }
}
