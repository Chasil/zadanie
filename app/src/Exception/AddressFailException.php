<?php

namespace App\Exception;

class AddressFailException extends \Exception
{
    public function __construct(string $message = "Searched address not exists", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}