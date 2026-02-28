<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function findCarsWithIdGreater(int $value): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where($qb->expr()->gt('c.id', ':value'));
        $qb->setParameter('value', $value);
        return $qb->getQuery()->getResult();
    }

    public function findCarsWithCertainName(string $value): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where($qb->expr()->eq('c.name', ':value'));
        $qb->setParameter('value', $value);
        return $qb->getQuery()->getResult();
    }
}
