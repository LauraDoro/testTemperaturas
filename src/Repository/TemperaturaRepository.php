<?php

namespace App\Repository;

use App\Entity\Temperatura;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Temperatura|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temperatura|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temperatura[]    findAll()
 * @method Temperatura[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemperaturaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temperatura::class);
    }

    // /**
    //  * @return Temperatura[] Returns an array of Temperatura objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Temperatura
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
