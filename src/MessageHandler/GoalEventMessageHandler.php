<?php

namespace App\MessageHandler;

use App\Entity\GoalEvent;
use App\Event\GoalEventEvent;
use App\Event\MatchEventList;
use App\Message\GoalEventMessage;
use App\Repository\GoalEventRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsMessageHandler]
final class GoalEventMessageHandler
{
    public function __construct(
        private readonly GoalEventRepository $goalEventRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function __invoke(GoalEventMessage $message): GoalEvent
    {
        $goalEvent = new GoalEvent();
        $goalEvent->setMinute($message->minute);
        $goalEvent->setTeamId($message->teamId);
        $goalEvent->setScorer($message->scorer);
        $goalEvent->setMatchId($message->matchId);
        $goalEvent->setAssistingPlayer($message->assistingPlayer);

        $this->goalEventRepository->save($goalEvent);

        $this->eventDispatcher->dispatch(new GoalEventEvent($goalEvent->getId()), MatchEventList::GOAL_EVENT_ADDED);

        return $goalEvent;
    }
}
