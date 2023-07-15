<?php

namespace App\Api\OpenMeteo\Response;

use App\Api\ApiResponse;
use Symfony\Component\Serializer\Annotation\SerializedName;

class OpenMeteoApiResponse implements ApiResponse
{
    #[SerializedName('current_weather')]
    private OpenMeteoApiResponseWeather $currentWeather;

    /**
     * @param OpenMeteoApiResponseWeather $currentWeather
     */
    public function setCurrentWeather(OpenMeteoApiResponseWeather $currentWeather): void
    {
        $this->currentWeather = $currentWeather;
    }

    /**
     * @return OpenMeteoApiResponseWeather
     */
    public function getCurrentWeather(): OpenMeteoApiResponseWeather
    {
        return $this->currentWeather;
    }

    public function getTemperature(): float
    {
        return $this->currentWeather->getTemperature();
    }


}