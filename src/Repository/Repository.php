<?php namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class Repository extends ServiceEntityRepository {

	protected static $entityClass;

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, static::$entityClass);
	}
}
