<?php

namespace App\Exception;

class InvalidApiRequestException extends \InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }
}
