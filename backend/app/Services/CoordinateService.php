<?php

namespace App\Services;

use App\Dto\CoordinateItemDto;
use App\Models\Coordinate;
use Illuminate\Pagination\LengthAwarePaginator;

class CoordinateService
{
    /**
     * @param CoordinateItemDto $dto
     *
     * @return Coordinate
     */
    public function store(CoordinateItemDto $dto): Coordinate
    {
        return Coordinate::create([
            'place_name' => $dto->place_name,
            'lat' => $dto->lat,
            'lon' => $dto->lon,
        ]);
    }

    /**
     * @param CoordinateItemDto $dto
     *
     * @return ?Coordinate
     */
    public function update(CoordinateItemDto $dto): ?Coordinate
    {
        $model = Coordinate::where('id', $dto->id)->first();

        if (is_null($model)) {
            return null;
        }

        $model->place_name = $dto->place_name;
        $model->lat = $dto->lat;
        $model->lon = $dto->lon;

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        Coordinate::where('id', $id)->delete();
    }

    /**
     * @param int $id
     *
     * @return ?Coordinate
     */
    public function getById(int $id): ?Coordinate
    {
        return Coordinate::where('id', $id)->first();
    }

    /**
     * @param ?int $page
     * @param ?int $limit
     *
     * @return LengthAwarePaginator
     */
    public function getList(?int $page = 1, ?int $limit = 20): LengthAwarePaginator
    {
        return Coordinate::paginate(perPage: $limit, page: $page);
    }
}
