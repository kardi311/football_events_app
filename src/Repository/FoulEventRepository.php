<?php

namespace App\Repository;

use App\Entity\FoulEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FoulEvent>
 */
class FoulEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FoulEvent::class);
    }

    public function save(FoulEvent $foulEvent): void
    {
        $em = $this->getEntityManager();
        $em->persist($foulEvent);
        $em->flush();
    }
}
