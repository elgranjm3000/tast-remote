<?php

namespace App\Repository;

use App\Entity\Taskboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Taskboard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Taskboard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Taskboard[]    findAll()
 * @method Taskboard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskboardRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Taskboard::class);
    }

//    /**
//     * @return Taskboard[] Returns an array of Taskboard objects
//     */
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
    public function findOneBySomeField($value): ?Taskboard
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
