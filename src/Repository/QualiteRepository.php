<?php

namespace App\Repository;

use App\Entity\Qualite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Qualite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Qualite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Qualite[]    findAll()
 * @method Qualite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QualiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Qualite::class);
    }

    // /**
    //  * @return Qualite[] Returns an array of Qualite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Qualite
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function qualiteLicencie(int $id){
        $dql = $this->getEntityManager()->createQuery('select q '
        . 'from App\Entity\Qualite q '
        . 'inner join App\Entity\Licencie l '
        . 'with l.laQualite = q.id '
        . 'where l.id = :id');
        $dql->setParameter('id', $id);
        $result = $dql->getResult();
        if($result){
            return $result;
        }else{
            return 'Le licencie precise n\'existe pas';
        }
    }
}
