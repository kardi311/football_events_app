<?php

namespace App\Message;

class AbstractEventMessage
{
    public function __construct(public string $type)
    {

    }
}
