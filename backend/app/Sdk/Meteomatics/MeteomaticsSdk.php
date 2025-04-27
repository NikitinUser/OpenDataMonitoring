<?php

namespace App\Sdk\Meteomatics;

use App\Sdk\Meteomatics\Dto\MeteomaticsResponseDto;
use App\Sdk\Meteomatics\Transformers\CurrentTemperatureItemTransformer;
use Illuminate\Support\Facades\Http;

class MeteomaticsSdk
{
    public function __construct(
        private CurrentTemperatureItemTransformer $currentTemperatureItemTransformer,
    ) {
    }

    /**
     * @param string $geoLatlon
     * @param string $needleDateTime
     *
     * @return MeteomaticsResponseDto
     */
    public function getTemperatureByDatetime(string $geoLatlon, string $needleDateTime): MeteomaticsResponseDto
    {
        $url = $this->getUrl($geoLatlon, $needleDateTime);
        $login = $this->getLogin();
        $pass = $this->getPass();

        $response = Http::withBasicAuth($login, $pass)
            ->get($url);

        return $this->currentTemperatureItemTransformer->transform($response);
    }

    /**
     * @param string $geoLatlon
     * @param string $needleDateTime
     *
     * @return string
     */
    private function getUrl(string $geoLatlon, string $needleDateTime): string
    {
        return sprintf(
            '%s/%s/%s/%s/%s',
            config('api.endpoints.meteomatics.host'),
            $needleDateTime,
            't_2m:C',
            $geoLatlon,
            'json'
        );
    }

    /**
     * @return string
     */
    private function getLogin(): string
    {
        return config('api.endpoints.meteomatics.login');
    }

    /**
     * @return string
     */
    private function getPass(): string
    {
        return config('api.endpoints.meteomatics.pass');
    }
}
