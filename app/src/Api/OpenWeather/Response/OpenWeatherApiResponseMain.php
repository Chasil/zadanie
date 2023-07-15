<?php

namespace App\Api\OpenWeather\Response;

use App\Api\WeatherParametersConverterTrait;

class OpenWeatherApiResponseMain
{
    use WeatherParametersConverterTrait;
    private float $temp;

    /**
     * @return float
     */
    public function getTemp(): float
    {
        return $this->temp;
    }

    /**
     * @param float $temp
     */
    public function setTemp(float $temp): void
    {
        $this->temp = $this->kalvinToCelsius($temp);
    }


}