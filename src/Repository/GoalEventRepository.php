<?php

namespace App\Repository;

use App\Entity\GoalEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GoalEvent>
 */
class GoalEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoalEvent::class);
    }

    public function save(GoalEvent $goalEvent): void
    {
        $em = $this->getEntityManager();
        $em->persist($goalEvent);
        $em->flush();
    }

    /**
     * @param string $matchId
     * @param string|null $teamId
     * @return GoalEvent[]
     */
    public function findAllForMatch(string $matchId, ?string $teamId = null): array
    {
        $criteria = ['matchId' => $matchId];
        if ($teamId !== null) {
            $criteria['teamId'] = $teamId;
        }

        return $this->findBy($criteria);
    }
}
