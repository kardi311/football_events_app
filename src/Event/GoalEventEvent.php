<?php

namespace App\Event;

class GoalEventEvent
{
    public function __construct(public readonly int $goalEventId)
    {

    }
}
