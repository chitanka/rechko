<?php

namespace App\Repository;

use App\Entity\DerivativeForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DerivativeForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method DerivativeForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method DerivativeForm[]    findAll()
 * @method DerivativeForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DerivativeFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DerivativeForm::class);
    }

    // /**
    //  * @return DerivativeForm[] Returns an array of DerivativeForm objects
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
    public function findOneBySomeField($value): ?DerivativeForm
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
