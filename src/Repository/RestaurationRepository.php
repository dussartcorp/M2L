<?php

namespace App\Repository;

use App\Entity\Restauration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restauration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restauration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restauration[]    findAll()
 * @method Restauration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restauration::class);
    }

    // /**
    //  * @return Restauration[] Returns an array of Restauration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restauration
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function getRestauration(){
        $dateResto = [];
        $dql = $this->getEntityManager()->createQuery('select r from App\Entity\Restauration r');
        $result = $dql->getResult();
        foreach($result as $q){
            
            if(!in_array($q->getDateRestauration()->format('Y-m-d'), array_column($dateResto, 'dateResto'))){ 
                $dateResto[] = [ 'dateResto' => $q->getDateRestauration()->format('Y-m-d'),
                'typeRepas' => [$q->getTypesRepas()]];
                
            } else {
                $key = array_search($q->getDateRestauration()->format('Y-m-d'), array_column($dateResto, 'dateResto'));
                array_push($dateResto[$key]['typeRepas'], $q->getTypesRepas());
            }
        }
        return $dateResto;
    }
}
