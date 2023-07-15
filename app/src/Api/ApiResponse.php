<?php

namespace App\Api;

interface ApiResponse
{
    public function getTemperature(): float;
}