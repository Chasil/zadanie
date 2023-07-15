<?php

namespace App\Api;

use App\Exception\WeatherMissingException;
use App\Serializer\OpenWeatherApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherApiClient extends AbstractController
{
    private const OPEN_WEATHER_DOMAIN_NAME = 'https://api.openweathermap.org/data/2.5/weather';

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
    public function fetchOpenWeatherMapAPIInformation(string $longitude, string $latitude): OpenWeatherApiResponse
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

        return $this->serializer->deserialize($responseContent, OpenWeatherApiResponse::class, 'json');
    }
}