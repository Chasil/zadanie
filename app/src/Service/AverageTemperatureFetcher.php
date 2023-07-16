<?php

namespace App\Service;

use App\Api\OpenMeteo\ApiClient;

class AverageTemperatureFetcher
{
    private array $apiClientsList;

    public function __construct(
        private ApiClient $openWeatherApiClient,
        private ApiClient $openMeteoApiClient
    )
    {
        $this->apiClientsList = [
            $this->openWeatherApiClient,
            $this->openMeteoApiClient
        ];
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @return float
     */
    public function fetch(float $latitude, float $longitude): float
    {
        $temperatures = [];
        foreach ($this->apiClientsList as $apiClient) {
            $apiData = $apiClient->fetchInformation($latitude, $longitude);
            $temperatures[] = $apiData->getTemperature($latitude, $longitude);
        }

        return array_sum($temperatures) / count($temperatures);
    }
}