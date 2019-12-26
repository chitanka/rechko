<?php

namespace App\Repository;

use App\Entity\WordTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WordTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordTranslation[]    findAll()
 * @method WordTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordTranslation::class);
    }

    // /**
    //  * @return WordTranslation[] Returns an array of WordTranslation objects
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
    public function findOneBySomeField($value): ?WordTranslation
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
