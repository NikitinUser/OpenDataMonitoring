<?php

namespace App\Sdk\Weatherapi;

use App\Sdk\Weatherapi\Dto\WeatherapiResponseDto;
use App\Sdk\Weatherapi\Transformers\CurrentTemperatureItemTransformer;
use Illuminate\Support\Facades\Http;

class WeatherapiSdk
{
    public function __construct(
        private CurrentTemperatureItemTransformer $currentTemperatureItemTransformer,
    ) {
    }

    /**
     * @param string $geoLatlon
     *
     * @return WeatherapiResponseDto
     */
    public function getCurrentTemperature(string $geoLatlon): WeatherapiResponseDto
    {
        $url = $this->getUrl('current.json');
        $token = $this->getToken();

        $response = Http::get($url, [
                'key' => $token,
                'q' => $geoLatlon,
            ]);

        return $this->currentTemperatureItemTransformer->transform($response);
    }

    /**
     * @param string $method
     *
     * @return string
     */
    private function getUrl(string $method): string
    {
        return sprintf(
            '%s/%s',
            config('api.endpoints.weatherapi.host'),
            $method
        );
    }

    /**
     * @return string
     */
    private function getToken(): string
    {
        return config('api.endpoints.weatherapi.key');
    }
}
