<?php

class DerivativeFormTable extends AbstractWordTable
{
	public function getByName($word)
	{
		return $this->createQuery('f')
			->leftJoin('f.BaseWord')
			->where('name = ? AND is_infinitive = 0', $word)
			->fetchArray();
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

	public function incrementSearchCount($id)
	{
		return $this->createQuery()
			->update()
			->set('search_count', 'search_count + 1')
			->where('id = ?', $id)
			->execute();
	}
}
