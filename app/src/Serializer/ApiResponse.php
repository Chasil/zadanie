<?php

namespace App\Serializer;

interface ApiResponse
{
    public function getTemperature(): float;
}