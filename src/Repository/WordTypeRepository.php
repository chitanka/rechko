<?php namespace App\Repository;

use App\Entity\WordType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WordType|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordType|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordType[]    findAll()
 * @method WordType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordTypeRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, WordType::class);
    }

    // /**
    //  * @return WordType[] Returns an array of WordType objects
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
    public function findOneBySomeField($value): ?WordType
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
