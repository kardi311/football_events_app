<?php

namespace App\Tests\Unit\Provider;

use App\Entity\FoulEvent;
use App\Entity\GoalEvent;
use App\Provider\StatisticsProvider;
use App\Repository\FoulEventRepository;
use App\Repository\GoalEventRepository;
use PHPUnit\Framework\TestCase;

class StatisticsProviderTest extends TestCase
{
    private FoulEventRepository $foulEventRepository;
    private GoalEventRepository $goalEventRepository;
    private StatisticsProvider $provider;

    protected function setUp(): void
    {
        $this->foulEventRepository = $this->createMock(FoulEventRepository::class);
        $this->goalEventRepository = $this->createMock(GoalEventRepository::class);
        $this->provider = new StatisticsProvider(
            $this->foulEventRepository,
            $this->goalEventRepository
        );
    }

    public function testGetStatisticsWithTeamId(): void
    {
        $matchId = 'match-123';
        $teamId = 'team-A';

        $foulEvents = [new FoulEvent(), new FoulEvent()];
        $goalEvents = [new GoalEvent()];

        $this->foulEventRepository->expects($this->once())
            ->method('findAllForMatch')
            ->with($matchId, $teamId)
            ->willReturn($foulEvents);

        $this->goalEventRepository->expects($this->once())
            ->method('findAllForMatch')
            ->with($matchId, $teamId)
            ->willReturn($goalEvents);

        $result = $this->provider->getStatistics($matchId, $teamId);

        $expected = [
            'match_id' => 'match-123',
            'team_id' => 'team-A',
            'statistics' => [
                'fouls' => 2,
                'goals' => 1
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testGetStatisticsWithoutTeamIdGroupedByTeam(): void
    {
        $matchId = 'match-123';

        $foul1 = $this->createMock(FoulEvent::class);
        $foul1->method('getTeamId')->willReturn('team-A');

        $foul2 = $this->createMock(FoulEvent::class);
        $foul2->method('getTeamId')->willReturn('team-B');

        $goal1 = $this->createMock(GoalEvent::class);
        $goal1->method('getTeamId')->willReturn('team-A');

        $this->foulEventRepository->method('findAllForMatch')
            ->with($matchId, null)
            ->willReturn([$foul1, $foul2]);

        $this->goalEventRepository->method('findAllForMatch')
            ->with($matchId, null)
            ->willReturn([$goal1]);

        $result = $this->provider->getStatistics($matchId);

        $this->assertEquals(1, $result['statistics']['team-A']['goals']);
        $this->assertEquals(1, $result['statistics']['team-A']['fouls']);
        $this->assertEquals(1, $result['statistics']['team-B']['fouls']);
        $this->assertArrayNotHasKey('goals', $result['statistics']['team-B']);
        $this->assertEquals($matchId, $result['match_id']);
    }
}
