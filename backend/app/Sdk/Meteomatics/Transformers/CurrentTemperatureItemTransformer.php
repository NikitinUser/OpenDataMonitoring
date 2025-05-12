<?php

namespace App\Sdk\Meteomatics\Transformers;

use App\Sdk\Meteomatics\Dto\MeteomaticsResponseDto;
use Illuminate\Support\Carbon;
use Illuminate\Http\Client\Response;

class CurrentTemperatureItemTransformer
{
    public function transform(Response $itemResponse): MeteomaticsResponseDto
    {
        $rawContent = $itemResponse->getBody()->getContents();
        $content = json_decode($rawContent, true) ?: [];

        $date = $content['data'][0]['coordinates'][0]['dates'][0]['date'] ?? null;
        if (!is_null($date)) {
            $date = Carbon::parse($date)->format('Y-m-d H:i:s');
        }

        return new MeteomaticsResponseDto(
            statusCode: $itemResponse->getStatusCode(),
            rawContent: $rawContent,
            lat: $content['data'][0]['coordinates'][0]['lat'] ?? null,
            lon: $content['data'][0]['coordinates'][0]['lon'] ?? null,
            date: $date,
            temperatureCells: $content['data'][0]['coordinates'][0]['dates'][0]['value'] ?? null,
        );
    }
}
