<?php

namespace App\Api\OpenWeather\Response;

class ApiResponse implements \App\Api\ApiResponse
{
    private ApiResponseMain $main;

    /**
     * @param ApiResponseMain $main
     */
    public function setMain(ApiResponseMain $main): void
    {
        $this->main = $main;
    }

    /**
     * @return ApiResponseMain
     */
    public function getMain(): ApiResponseMain
    {
        return $this->main;
    }

    public function getTemperature(): float
    {
        return $this->main->getTemp();
    }


}