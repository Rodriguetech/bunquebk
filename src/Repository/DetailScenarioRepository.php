<?php

namespace App\Repository;

use App\Entity\DetailScenario;
use App\Entity\Scenario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailScenario|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailScenario|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailScenario[]    findAll()
 * @method DetailScenario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailScenarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailScenario::class);
    }

    /**
     * @return DetailScenario[] Returns an array of DetailScenario objects
     */
    
    public function getListeDetailScenarioByScenario(Scenario $scenario)
    {
        return $this->createQueryBuilder('d')
            ->where('d.scenario = :val')
            ->setParameter('val', $scenario)
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return DetailScenario[] Returns an array of DetailScenario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailScenario
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
