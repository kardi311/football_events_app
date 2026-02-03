<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function findByFullName(string $fullName): ?Player
    {
        return $this->createQueryBuilder('p')
            ->andWhere('CONCAT(p.firstName, \' \', p.lastName) = :val')
            ->setParameter("val", $fullName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function addPlayer(string $playerName, int $teamId): Player
    {
        $player = new Player();
        $nameExplode = explode(' ', trim($playerName));
        $player->setFirstName($nameExplode[0]);
        $player->setLastName($nameExplode[1]);
        $player->setTeamId($teamId);

        $em = $this->getEntityManager();
        $em->persist($player);
        $em->flush();

        return $player;
    }
}
