<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }
    public function findByName(string $teamName): ?Team
    {
        return $this->findOneBy(['name' => $teamName]);
    }

    public function addTeam(string $teamName): Team
    {
        $team = new Team();
        $team->setName($teamName);
        $em = $this->getEntityManager();
        $em->persist($team);
        $em->flush();

        return $team;
    }
}
