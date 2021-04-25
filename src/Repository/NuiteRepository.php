<?php

namespace App\Repository;

use App\Entity\Nuitee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Nuitee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nuitee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nuitee[]    findAll()
 * @method Nuitee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NuiteeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nuitee::class);
    }

    // /**
    //  * @return Nuitee[] Returns an array of Nuitee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nuitee
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
