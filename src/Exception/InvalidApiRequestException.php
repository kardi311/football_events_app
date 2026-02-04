<?php

namespace App\Exception;

class InvalidApiRequestException extends \InvalidArgumentException
{
    public function __construct($message = "")
    {
        parent::__construct($message, 400);
    }

}
