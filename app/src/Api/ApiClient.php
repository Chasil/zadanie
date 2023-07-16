<?php

namespace App\Api;

interface ApiClient
{
    public function fetchInformation(string $longitude, string $latitude): ApiResponse;
}