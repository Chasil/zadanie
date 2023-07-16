<?php

namespace App\Api\OpenMeteo;

use App\Api\OpenMeteo\Response\ApiResponse;
use App\Exception\WeatherMissingException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiClient implements \App\Api\ApiClient
{
    private const DOMAIN_NAME = 'https://api.open-meteo.com/v1/forecast';

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
    public function fetchInformation(string $longitude, string $latitude): ApiResponse
    {
        $response = $this->httpClient->request(
            'GET',
            self::DOMAIN_NAME,
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

        return $this->serializer->deserialize($responseContent, ApiResponse::class, 'json');
    }
}