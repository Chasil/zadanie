<?php

namespace App\Api;

trait WeatherParametersConverterTrait
{
    /**
     * @param float $temparature
     * @return float
     */
    public function fahrenheitToCelsius(float $temparature): float
    {
        return ($temparature - 32) / 1.8;
    }

    /**
     * @param float $temerature
     * @return float
     */
    public function kalvinToCelsius(float $temerature): float
    {
        return $temerature - 273.15;
    }

    /**
     * @param array $temperatures
     * @return float
     */
    public function getAverageTemperature(array $temperatures): float
    {

        return array_sum($temperatures) / count($temperatures);
    }
}