<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Annotation\SerializedName;

class OpenMeteoApiResponse
{
    private float $latitude;
    private float $longitude;
    #[SerializedName('current_weather')]
    private OpenMeteoApiResponseWeather $currentWeather;

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @param OpenMeteoApiResponseWeather $currentWeather
     */
    public function setCurrentWeather(OpenMeteoApiResponseWeather $currentWeather): void
    {
        $this->currentWeather = $currentWeather;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return OpenMeteoApiResponseWeather
     */
    public function getCurrentWeather(): OpenMeteoApiResponseWeather
    {
        return $this->currentWeather;
    }


}