<?php

namespace App\Api\OpenWeather\Response;

use App\Api\ApiResponse;

class OpenWeatherApiResponse implements ApiResponse
{
    private OpenWeatherApiResponseMain $main;

    /**
     * @param OpenWeatherApiResponseMain $main
     */
    public function setMain(OpenWeatherApiResponseMain $main): void
    {
        $this->main = $main;
    }

    /**
     * @return OpenWeatherApiResponseMain
     */
    public function getMain(): OpenWeatherApiResponseMain
    {
        return $this->main;
    }

    public function getTemperature(): float
    {
        return $this->main->getTemp();
    }


}