<?php

namespace App\Api;

use App\Exception\WeatherMissingException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenMeteoApiClient extends AbstractController
{
    private const OPEN_METEO_DOMAIN_NAME = 'https://api.open-meteo.com/v1/forecast';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private SerializerInterface $serializer
    ) {}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws WeatherMissingException
     */
    public function fetchOpenMeteoAPIInformation(string $longitude, string $latitude): float
    {
        $response = $this->httpClient->request(
            'GET',
            self::OPEN_METEO_DOMAIN_NAME,
            [
                'query' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current_weather' => 'true'
                ]
            ]
        );

        if(!$response) {
            throw new WeatherMissingException();
        }

        $responseContent = $response->getContent();
        $weatherData = json_decode($responseContent);

        return ['temperature' => $weatherData->current_weather->temperature];
    }
}