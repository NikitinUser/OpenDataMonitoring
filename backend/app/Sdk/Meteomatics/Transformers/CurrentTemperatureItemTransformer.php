<?php

namespace App\Sdk\Meteomatics\Transformers;

use App\Sdk\Meteomatics\Dto\MeteomaticsResponseDto;
use Illuminate\Http\Client\Response;

class CurrentTemperatureItemTransformer
{
    public function transform(Response $itemResponse): MeteomaticsResponseDto
    {
        $rawContent = $itemResponse->getBody()->getContents();
        $content = json_decode($rawContent, true) ?: [];

        return new MeteomaticsResponseDto(
            statusCode: $itemResponse->getStatusCode(),
            rawContent: $rawContent,
            lat: $content['data'][0]['coordinates'][0]['lat'] ?? null,
            lon: $content['data'][0]['coordinates'][0]['lon'] ?? null,
            date: $content['data'][0]['coordinates'][0]['dates'][0]['date'] ?? null,
            temperatureCells: $content['data'][0]['coordinates'][0]['dates'][0]['value'] ?? null,
        );
    }
}
