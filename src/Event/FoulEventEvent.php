<?php

namespace App\Event;

class FoulEventEvent
{
    public function __construct(public readonly int $foulEventId)
    {

    }
}
