<?php

class AbstractWordTable extends Doctrine_Table
{
	public function getSimilar($name)
	{
		$words = $this->createQuery()
			->where('name_condensed = ?', MyI18nToolkit::condenseWord($name))
			->orderby('name')
			->groupby('name')
			->fetchArray();

		return $this->sortWordsByLevenshtein($name, $words);
	}


	public function getMaxId()
	{
		// не работи: връща false, не знам защо
		//return $this->createQuery()->select('MAX(id)')->fetchOne(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);

		$r = $this->createQuery()->select('MAX(id)')->fetchOne(array(), Doctrine_Core::HYDRATE_ARRAY);
		return array_shift($r);
	}


	public function sortWordsByLevenshtein($base, $words)
	{
		$levs = array();
		foreach ($words as $i => $word) {
			$levs[$i] = MyI18nToolkit::levenshtein($base, $word['name']);
		}
		asort($levs);

		$sorted = array();
		foreach (array_keys($levs) as $key) {
			$sorted[] = $words[$key];
		}

		return $sorted;
	}
}
