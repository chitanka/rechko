<?php

class IncorrectFormTable extends Doctrine_Table
{
	public function getByNameWithCorrectWord($name)
	{
		return $this->createQuery('i')
			->select('i.name, c.name')
			->leftJoin('i.CorrectWord c')
			->where('i.name = ?', $name)
			->groupBy('i.name, c.name')
			->fetchArray();
	}

	public function getMostSearched($limit = 30)
	{
		return $this->createQuery()
			->select('name, search_count')
			->orderby('search_count DESC')
			->where('search_count > 0')
			->limit($limit)
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
