<?php

namespace App\Sdk\Weatherapi\Transformers;

use App\Sdk\Weatherapi\Dto\WeatherapiResponseDto;
use Illuminate\Http\Client\Response;

class CurrentTemperatureItemTransformer
{
    public function transform(Response $itemResponse): WeatherapiResponseDto
    {
        $rawContent = $itemResponse->getBody()->getContents();
        $content = json_decode($rawContent, true) ?: [];

        return new WeatherapiResponseDto(
            statusCode: $itemResponse->getStatusCode(),
            rawContent: $rawContent,
            message: $content['error']['message'] ?? null,
            lat: $content['location']['lat'] ?? null,
            lon: $content['location']['lon'] ?? null,
            date: $content['current']['last_updated'] ?? null,
            temperatureCells: $content['current']['temp_c'] ?? null,
        );
    }
}
