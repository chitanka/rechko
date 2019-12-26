<?php namespace App\Repository;

use App\Entity\IncorrectForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method IncorrectForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncorrectForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncorrectForm[]    findAll()
 * @method IncorrectForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncorrectFormRepository extends Repository {

    protected static $entityClass = IncorrectForm::class;

	public function findMostSearched($limit = 30) {
		return $this->createQueryBuilder('f')
			->where('f.searchCount > 0')
			->setMaxResults($limit)
			->orderBy('f.searchCount', 'DESC')
			->getQuery()
			->getResult();
	}

	// /**
    //  * @return IncorrectForm[] Returns an array of IncorrectForm objects
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
    public function findOneBySomeField($value): ?IncorrectForm
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
