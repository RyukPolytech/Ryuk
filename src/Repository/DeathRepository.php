<?php

namespace App\Repository;

use App\Entity\Death;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Death>
 */
class DeathRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Death::class);
    }

    /**
    * @return array Returns an array of the top 5 most common first names and their counts
    */
    public function findTop5FirstName(): array
    {
        return $this->createQueryBuilder('d')
            ->select('d.first_name as firstName, COUNT(d.first_name) as deathCount')
            ->groupBy('d.first_name')
            ->orderBy('deathCount', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    /**
    * @return array Returns an array of the top 5 departments with the most deaths and their counts
    */
    public function findTop5Departments(): array
    {
        return $this->createQueryBuilder('d')
            ->select('dept.name as departmentName, COUNT(d.id) as deathCount')
            ->leftJoin('d.department', 'dept')
            ->groupBy('dept.name')
            ->orderBy('deathCount', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

}
