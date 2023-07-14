<?php

namespace App\Service;

class WeatherParametersConverter
{
    public function fahrenheitToCelsius(float $temparature): float {
        return ($temparature - 32) / 1.8;
    }

    public function kalvinToCelsius(float $temerature): float {
        return $temerature - 273.15;
    }

    public function getAverageTemperature(array $temperatures) {
        return array_sum($temperatures) / count($temperatures);
    }
}