<?php

namespace App\Serializer;

class OpenWeatherApiResponseMain
{
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
        $this->temp = $temp;
    }


}