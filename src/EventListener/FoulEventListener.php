<?php

namespace App\EventListener;

use App\Event\MatchEventList;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: MatchEventList::FOUL_EVENT_ADDED, method: 'onFoulEvent')]
final class FoulEventListener
{
    public function onFoulEvent(CustomEvent $event): void
    {
        // we can add here some logic to notify subscribers about match events
    }
}
