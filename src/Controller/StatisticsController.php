<?php

namespace App\Controller;

use App\Provider\StatisticsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class StatisticsController extends AbstractController
{
    #[Route('/statistics', name: 'app_statistics', methods: ['GET'])]
    public function index(
        Request $request,
        StatisticsProvider $statisticsProvider
    ): JsonResponse
    {
        $matchId = $request->query->get('match_id');
        if (!$matchId) {
            throw new \InvalidArgumentException('match_id is required', 400);
        }

        $teamId = $request->query->get('team_id');

        $statistics = $statisticsProvider->getStatistics($matchId, $teamId);

        return $this->json($statistics);
    }
}
