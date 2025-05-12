<?php

namespace App\Services\Features\Interfaces;

use App\Dto\CoordinateItemDto;
use App\Dto\CoordinateTemperatureItemDto;

interface CurrentTempInterface
{
    /**
     * @param CoordinateItemDto $coordinateItemDto
     *
     * @return ?CoordinateTemperatureItemDto
     */
    public function handle(CoordinateItemDto $coordinateItemDto): ?CoordinateTemperatureItemDto;
}
