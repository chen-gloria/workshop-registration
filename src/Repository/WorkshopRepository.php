<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Workshop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Workshop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workshop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workshop[]    findAll()
 * @method Workshop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workshop::class);
    }

    /**
     * @return Workshop[] Returns an array of Workshop objects
     */

    public function findAllOrderedByNewest()
    {
        return $this->addIsSetDateQueryBuilder()
            ->orderBy('w.startsAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    private function addIsSetDateQueryBuilder(QueryBuilder $qb = null)
    {
        return $this->getOrCreateQueryBuilder($qb)
            ->andWhere('w.startsAt IS NOT NULL');
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null)
    {
        return $qb ?: $this->createQueryBuilder('w');
    }

    /**
     * @return Workshop[] Returns an array of Workshop objects
     */

    public function findUsersRegisteredByWorkshopId($workshopId)
    {
        return $this->addIsSetDateQueryBuilder()
            ->leftJoin('w.users', 'u')
            ->andWhere('w.id = :workshopId')
            ->setParameter('workshopId', $workshopId)
            ->addSelect('u')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Workshop
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
