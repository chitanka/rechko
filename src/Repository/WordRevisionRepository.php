<?php

namespace App\Repository;

use App\Entity\WordRevision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WordRevision|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordRevision|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordRevision[]    findAll()
 * @method WordRevision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRevisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordRevision::class);
    }

    // /**
    //  * @return WordRevision[] Returns an array of WordRevision objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WordRevision
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
