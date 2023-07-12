<?php

namespace App\Exception;

class WeatherMissingException extends \Exception
{
    public function __construct(string $message = "No weather info for these coordinates", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}