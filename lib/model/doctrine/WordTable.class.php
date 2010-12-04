<?php

class WordTable extends AbstractWordTable
{
	public function getByName($name)
	{
		return $this->createQuery('w')
			->leftJoin('w.Type')
			//->leftJoin('w.IncorrectForms')
			//->leftJoin('w.DerivativeForms')
			->where('name = ?', $name)
			->execute();
	}

	public function getNamesByPrefix($prefix, $limit = 10)
	{
		return $this->createQuery()
			->select('name')
			->where('name LIKE ?', $prefix.'%')
			->limit($limit)
			->groupBy('name')
			->fetchArray();
	}

	public function getByTypeId($typeId, $limit = 30)
	{
		return $this->getByTypeIdQuery($typeId, $limit)->execute();
	}

	public function getByTypeIdQuery($typeId, $limit = 30)
	{
		$q = $this->createQuery('w')->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)
			->select('w.name')
			->where('w.type_id = ?', $typeId)
			->limit($limit)
			->orderby('w.name');

		return $q;
	}

	public function getMostSearched($limit = 30)
	{
		return $this->createQuery()
			->select('name, search_count')
			->where('search_count > 0')
			->limit($limit)
			->orderby('search_count DESC')
			->fetchArray();
	}

	public function getRandomWord()
	{
		$maxId = $this->getMaxId();
		do {
			$data = $this->createQuery()
				->select('name')
				->where('id = ?', mt_rand(1, $maxId))
				->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
		} while ($data == false);

		return $data['name'];
	}


	public function incrementSearchCount($id)
	{
		return $this->createQuery()
			->update()
			->set('search_count', 'search_count + 1')
			->where('id = ?', $id)
			->execute();
	}


	/**
	* Check if there is word with given name and/or type.
	*/
	public function exists($name, $type = null)
	{
		$q = $this->createQuery('w')->where('w.name = ?', $name);

		if ( ! is_null($type) ) {
			$q->leftJoin('w.Type t')->andWhere('t.name = ?', $type);
		}

		return $q->count();
	}

}
