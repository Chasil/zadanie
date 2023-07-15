<?php

namespace App\Api\OpenMeteo\Response;

class OpenMeteoApiResponseWeather
{
    private float $temperature;

    /**
     * @param float $temperature
     */
    public function setTemperature(float $temperature): void
    {
        $this->temperature = $temperature;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }
}