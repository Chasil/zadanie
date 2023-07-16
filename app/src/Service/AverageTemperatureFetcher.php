<?php

namespace App\Service;

use App\Api\OpenMeteo\ApiClient;
use App\Exception\WeatherMissingException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class AverageTemperatureFetcher
{
    /** @var apiClient[]  */
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

    /***
     * @param float $latitude
     * @param float $longitude
     * @return float
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws WeatherMissingException
     */
    public function fetch(float $latitude, float $longitude): float
    {
        $temperatures = [];
        foreach ($this->apiClientsList as $apiClient) {
            $apiData = $apiClient->fetchInformation($latitude, $longitude);
            $temperatures[] = $apiData->getTemperature();
        }

        return array_sum($temperatures) / count($temperatures);
    }
}