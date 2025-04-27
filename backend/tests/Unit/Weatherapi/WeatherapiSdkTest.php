<?php

namespace Tests\Unit\Weatherapi;

use App\Sdk\Weatherapi\WeatherapiSdk;
use App\Sdk\Weatherapi\Dto\WeatherapiResponseDto;
use App\Sdk\Weatherapi\Transformers\CurrentTemperatureItemTransformer;
use Http;
use Mockery;
use Tests\TestCase;

class WeatherapiSdkTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::fake();

        $this->transformerCurrentTemperature = Mockery::mock(CurrentTemperatureItemTransformer::class);
        $this->sdk = new WeatherapiSdk($this->transformerCurrentTemperature);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetCurrentTemperatureSuccess(): void
    {
        $this->transformerCurrentTemperature
            ->shouldReceive('transform')
            ->once()
            ->andReturn(new WeatherapiResponseDto(
                statusCode: 200,
                rawContent: ''
            ));

        $dto = $this->sdk->getCurrentTemperature('');

        $this->assertInstanceOf(WeatherapiResponseDto::class, $dto);
    }
}
