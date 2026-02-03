<?php

namespace App\MessageHandler;

use App\Entity\FoulEvent;
use App\Event\FoulEventEvent;
use App\Event\MatchEventList;
use App\Message\FoulEventMessage;
use App\Repository\FoulEventRepository;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsMessageHandler]
final class FoulEventMessageHandler
{
    public function __construct(
        private readonly PlayerRepository $playerRepository,
        private readonly TeamRepository $teamRepository,
        private readonly FoulEventRepository $foulEventRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
    )
    {

    }

    public function __invoke(FoulEventMessage $message): void
    {
        $team = $this->teamRepository->findByName($message->teamName);
        if (!$team) {
            $team = $this->teamRepository->addTeam($message->teamName);

        }
        if (!$team->getId()) {
            throw new \InvalidArgumentException('Team not found');
        }

        $teamId = $team->getId();

        $player = $this->playerRepository->findByFullName($message->playerName);
        if (!$player) {
            $player = $this->playerRepository->addPlayer($message->playerName, $teamId);
        }

        if (!$player) {
            throw new \InvalidArgumentException('Player not found');
        }

        $foulEvent = new FoulEvent();
        $foulEvent->setMinute($message->minute);
        $foulEvent->setSecond($message->second);
        $foulEvent->setTeamId($team->getId());
        $foulEvent->setPlayerId($player->getId());
        $foulEvent->setMatchId($message->matchId);

        $this->foulEventRepository->save($foulEvent);

        $this->eventDispatcher->dispatch(new FoulEventEvent($foulEvent->getId()), MatchEventList::FOUL_EVENT_ADDED);
    }
}
