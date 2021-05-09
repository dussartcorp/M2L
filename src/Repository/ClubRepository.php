<?php

namespace App\Repository;

use App\Entity\Club;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Club|null find($id, $lockMode = null, $lockVersion = null)
 * @method Club|null findOneBy(array $criteria, array $orderBy = null)
 * @method Club[]    findAll()
 * @method Club[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Club::class);
    }

    // /**
    //  * @return Club[] Returns an array of Club objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Club
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function clubLicencie(int $id){
        $dql = $this->getEntityManager()->createQuery('select c.id, c.nom, c.adresse1, c.adresse2, c.cp, c.ville, c.tel '
        . 'from App\Entity\Club c '
        . 'inner join App\Entity\Licencie l '
        . 'with l.leClub = c.id '
        . 'where l.id = :id');
        $dql->setParameter('id', $id);
        $result = $dql->getResult();
        if($result){
            return $result;
        }else{
            return 'Le licencie precise n\'existe pas';
        }
    }

    public function findAll(){
        $dql = $this->getEntityManager()->createQuery('select c.id, c.nom, c.adresse1, c.adresse2, c.cp, c.ville, c.tel '
        . 'from App\Entity\Club c');
        $result = $dql->getResult();
        if($result){
            return $result;
        }else{
            return 'Le licencie precise n\'existe pas';
        }
    }
}
