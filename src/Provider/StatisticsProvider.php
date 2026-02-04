<?php
declare(strict_types=1);

namespace App\Provider;

use App\Entity\FoulEvent;
use App\Entity\GoalEvent;
use App\Repository\FoulEventRepository;
use App\Repository\GoalEventRepository;

class StatisticsProvider
{
    public function __construct(
        private readonly FoulEventRepository $foulEventRepository,
        private readonly GoalEventRepository $goalEventRepository
    )
    {

    }

    public function getStatistics(string $matchId, ?string $teamId = null): array
    {
        $foulEvents = $this->foulEventRepository->findAllForMatch($matchId, $teamId);
        $goalEvents = $this->goalEventRepository->findAllForMatch($matchId, $teamId);

        $response = [
            'match_id' => $matchId,
        ];

        if ($teamId !== null) {
            $response['team_id'] = $teamId;
            $response['statistics'] = ['fouls' => count($foulEvents), 'goals' => count($goalEvents)];
            $response['statistics'] = array_filter($response['statistics']);

            return $response;
        }

        $response['statistics'] = $this->getEvents($foulEvents, $goalEvents);

        return $response;
    }

    /**
     * @param FoulEvent[] $foulEvents
     * @param GoalEvent[] $goalEvents
     * @return array
     */
    private function getEvents(array $foulEvents, array $goalEvents): array
    {
        $statistics = [];
        foreach ($foulEvents as $foulEvent) {
            $statistics[$foulEvent->getTeamId()]['fouls'] ??= 0;
            $statistics[$foulEvent->getTeamId()]['fouls']++;
        }

        foreach ($goalEvents as $goalEvent) {
            $statistics[$goalEvent->getTeamId()]['goals'] ??= 0;
            $statistics[$goalEvent->getTeamId()]['goals']++;
        }

        return $statistics;
    }
}
