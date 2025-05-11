<?php

namespace App\Services;

use App\Dto\CoordinateTemperatureItemDto;
use App\Dto\CoordinateTemperatureRequestListDto;
use App\Models\CoordinateTemperature;
use Illuminate\Pagination\LengthAwarePaginator;

class CoordinateTemperatureService
{
    /**
     * @param CoordinateTemperatureRequestListDto $dto
     * @param ?int $page
     * @param ?int $limit
     *
     * @return LengthAwarePaginator
     */
    public function getList(CoordinateTemperatureRequestListDto $dto, ?int $page = 1, ?int $limit = 20): LengthAwarePaginator
    {
        $query = (new CoordinateTemperature())->newQuery();

        foreach ($dto as $key => $value) {
            $query->when(!empty($value), function ($query) use ($key, $value)  {
                $query->where($key, $value);
            });
        }

        return $query->paginate(perPage: $limit, page: $page);
    }

    public function store(CoordinateTemperatureItemDto $dto): CoordinateTemperature
    {
        return CoordinateTemperature::create([
            'coordinate_id' => $dto->coordinate_id,
            'temp_cels' => $dto->temp_cels,
            'temp_datetime' => $dto->temp_datetime,
            'source' => $dto->source,
        ]);
    }
}
