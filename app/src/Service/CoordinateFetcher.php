<?php

namespace App\Service;

use App\Exception\AddressFailException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CoordinateFetcher
{
    public function __construct(
        private HttpClientInterface $httpClient
    ) {}

    /**
     * @throws AddressFailException|TransportExceptionInterface
     */
    public function get(string $city, string $country): array
    {

        $response = $this->httpClient->request(
            'GET',
            'https://nominatim.openstreetmap.org/search',
            [
                'query' => [
                    'format' => 'json',
                    'q' => $city . ',' . $country
                ]
            ]
        );

        $data = json_decode($response->getContent());

        if(empty($data)) {
            throw new AddressFailException();
        }

        return ['latitude' => $data[0]->lat, 'longitude' => $data[0]->lon];
    }
}