<?php

namespace App\Api\OpenMeteo\Response;

use Symfony\Component\Serializer\Annotation\SerializedName;

class ApiResponse implements \App\Api\ApiResponse
{
    #[SerializedName('current_weather')]
    private ApiResponseWeather $currentWeather;

    /**
     * @param ApiResponseWeather $currentWeather
     */
    public function setCurrentWeather(ApiResponseWeather $currentWeather): void
    {
        $this->currentWeather = $currentWeather;
    }

    /**
     * @return ApiResponseWeather
     */
    public function getCurrentWeather(): ApiResponseWeather
    {
        return $this->currentWeather;
    }

    public function getTemperature(): float
    {
        return $this->currentWeather->getTemperature();
    }


}