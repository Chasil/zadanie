<?php

namespace App\Api;

use App\Exception\WeatherMissingException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient
{
    private const DOMAIN_NAME = 'https://api.openweathermap.org/data/2.5/weather';

    public function __construct(private readonly HttpClientInterface $httpClient) {}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws WeatherMissingException
     */
    public function fetchAPIInformation(string $lon, string $lat): string
    {
        $response = $this->httpClient->request(
            'GET',
            self::DOMAIN_NAME,
            [
                'query' => [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => '197837dbbbf1618b58c9b2fb4d0b2ede'
                ]
            ]
        );

        if(!$response) {
            throw new WeatherMissingException();
        }

        return $response->getContent();
    }
}