<?php

namespace App\MessageHandler;

use App\Entity\FoulEvent;
use App\Event\FoulEventEvent;
use App\Event\MatchEventList;
use App\Message\FoulEventMessage;
use App\Repository\FoulEventRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsMessageHandler]
final class FoulEventMessageHandler
{
    public function __construct(
        private readonly FoulEventRepository $foulEventRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(FoulEventMessage $message): FoulEvent
    {
        $foulEvent = new FoulEvent();
        $foulEvent->setMinute($message->minute);
        $foulEvent->setSecond($message->second);
        $foulEvent->setTeamId($message->teamId);
        $foulEvent->setPlayer($message->player);
        $foulEvent->setMatchId($message->matchId);

        $this->foulEventRepository->save($foulEvent);

        $this->eventDispatcher->dispatch(new FoulEventEvent($foulEvent->getId()), MatchEventList::FOUL_EVENT_ADDED);

        return $foulEvent;
    }
}
