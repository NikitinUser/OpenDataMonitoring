<?php

namespace App\Sdk\Weatherapi\Transformers;

use App\Sdk\Weatherapi\Dto\WeatherapiResponseDto;
use Illuminate\Support\Carbon;
use Illuminate\Http\Client\Response;

class CurrentTemperatureItemTransformer
{
    public function transform(Response $itemResponse): WeatherapiResponseDto
    {
        $rawContent = $itemResponse->getBody()->getContents();
        $content = json_decode($rawContent, true) ?: [];

        $date = $content['current']['last_updated'] ?? null;
        if (!is_null($date)) {
            $date = Carbon::parse($date)->format('Y-m-d H:i:s');
        }

        return new WeatherapiResponseDto(
            statusCode: $itemResponse->getStatusCode(),
            rawContent: $rawContent,
            message: $content['error']['message'] ?? null,
            lat: $content['location']['lat'] ?? null,
            lon: $content['location']['lon'] ?? null,
            date: $date,
            temperatureCells: $content['current']['temp_c'] ?? null,
        );
    }
}
