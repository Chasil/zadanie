<?php

namespace App\Serializer;

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