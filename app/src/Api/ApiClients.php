<?php

namespace App\Api;

interface ApiClients
{
    public function fetchAPIInformation(string $longitude, string $latitude): ApiResponse;
}