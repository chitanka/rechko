<?php

namespace App\Repository;

use App\Entity\IncorrectFormRevision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method IncorrectFormRevision|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncorrectFormRevision|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncorrectFormRevision[]    findAll()
 * @method IncorrectFormRevision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncorrectFormRevisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IncorrectFormRevision::class);
    }

    // /**
    //  * @return IncorrectFormRevision[] Returns an array of IncorrectFormRevision objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IncorrectFormRevision
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
