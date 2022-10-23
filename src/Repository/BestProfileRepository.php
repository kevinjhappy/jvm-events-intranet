<?php

namespace App\Repository;

use App\Entity\BestProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BestProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method BestProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method BestProfile[]    findAll()
 * @method BestProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BestProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BestProfile::class);
    }

    // /**
    //  * @return BestProfile[] Returns an array of BestProfile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BestProfile
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
