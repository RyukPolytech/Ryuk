<?php

namespace App\Repository;

use App\Entity\DeathCause;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeathCause>
 */
class DeathCauseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeathCause::class);
    }

    /**
    * @return array Returns an array of the top 5 most common death causes and their counts
    */
    public function findTop5DeathCause(): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere("d.title NOT LIKE 'Toutes Causes'")
            ->select('d.title as title, d.totalDeath as deathCount')
            ->orderBy('deathCount', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?DeathCause
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
