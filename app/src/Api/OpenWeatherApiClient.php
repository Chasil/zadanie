<?php

namespace App\Api;

use App\Exception\WeatherMissingException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherApiClient
{
    private const OPEN_WEATHER_DOMAIN_NAME = 'https://api.openweathermap.org/data/2.5/weather';

    public function __construct(private readonly HttpClientInterface $httpClient) {}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws WeatherMissingException
     */
    public function fetchOpenWeatherMapAPIInformation(string $longitude, string $latitude): \stdClass
    {
        $response = $this->httpClient->request(
            'GET',
            self::OPEN_WEATHER_DOMAIN_NAME,
            [
                'query' => [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'appid' => '197837dbbbf1618b58c9b2fb4d0b2ede'
                ]
            ]
        );

        if(!$response) {
            throw new WeatherMissingException();
        }

        $responseContent = $response->getContent();

        return json_decode($responseContent);
    }
}