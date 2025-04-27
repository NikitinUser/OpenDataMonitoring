<?php

namespace Tests\Unit\Meteomatics;

use App\Sdk\Meteomatics\MeteomaticsSdk;
use App\Sdk\Meteomatics\Dto\MeteomaticsResponseDto;
use App\Sdk\Meteomatics\Transformers\CurrentTemperatureItemTransformer;
use Http;
use Mockery;
use Tests\TestCase;

class MeteomaticsSdkTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::fake();

        $this->transformerCurrentTemperature = Mockery::mock(CurrentTemperatureItemTransformer::class);
        $this->sdk = new MeteomaticsSdk($this->transformerCurrentTemperature);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetTemperatureByDatetimeSuccess(): void
    {
        $this->transformerCurrentTemperature
            ->shouldReceive('transform')
            ->once()
            ->andReturn(new MeteomaticsResponseDto(
                statusCode: 200,
                rawContent: ''
            ));

        $dto = $this->sdk->getTemperatureByDatetime('', '');

        $this->assertInstanceOf(MeteomaticsResponseDto::class, $dto);
    }
}
