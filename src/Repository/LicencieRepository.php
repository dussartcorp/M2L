<?php

namespace App\Repository;

use App\Entity\Licencie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Licencie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licencie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licencie[]    findAll()
 * @method Licencie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicencieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Licencie::class);
    }

    // /**
    //  * @return Licencie[] Returns an array of Licencie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Licencie
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function isNumLicenceValid(string $numLicence){
        $dql = $this->getEntityManager()->createQuery('select l.numLicence '
        . 'from App\Entity\Licencie l '
        . 'where l.numLicence = :licence');
        $dql->setParameter('licence', $numLicence);
        $result = $dql->getResult();
        if($result){
            return 'ok';
        }else{
            return 'ko';
        }
    }
    
    public function isNumLicenceExist(string $numLicence){
        $dql = $this->getEntityManager()->createQuery('select l.numLicence '
        . 'from App\Entity\User l '
        . 'where l.numLicence = :licence');
        $dql->setParameter('licence', $numLicence);
        $result = $dql->getResult();
        if($result){
            return 'ok';
        }else{
            return 'ko';
        }
    }

    public function recupIdCompte(string $numLicence){
        $dql = $this->getEntityManager()->createQuery('select l.id '
        . 'from App\Entity\User l '
        . 'where l.numLicence = :licence');
        $dql->setParameter('licence', $numLicence);
        $result = $dql->getResult();
        if($result){
            return $result;
        }else{
            return 'ko';
        }
    }

    public function addIdCompte(string $numLicence, int $id){
        $dql = $this->getEntityManager()->createQuery('Update App\Entity\Licencie l '
        . 'set l.compte = :id '
        . 'where l.numLicence = :licence');
        $dql->setParameter('licence', $numLicence);
        $dql->setParameter('id', $id);
        $result = $dql->getResult();
        if($result){
            return $result;
        }else{
            return 'ko';
        }
    }
}
