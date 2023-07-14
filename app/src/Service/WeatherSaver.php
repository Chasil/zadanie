<?php

namespace App\Service;

use App\Entity\Weather;
use Doctrine\Persistence\ManagerRegistry;

readonly class WeatherSaver
{
    public function __construct(private ManagerRegistry $doctrine) {}

    public function save(string $city, string $country, float $averageTemperature): void
    {
        $entityWeather = new Weather();
        $entityWeather->setCity($city);
        $entityWeather->setCountry($country);
        $entityWeather->setAverageTemperature($averageTemperature);
        $entityWeather->setAdded(new \DateTimeImmutable());

        $em = $this->doctrine->getManager();
        $em->persist($entityWeather);
        $em->flush();
    }
}