<?php

class IncorrectFormRevisionTable extends RevisionTable
{
	public function getRecentWithObject()
	{
		return $this->createQuery('r')
			->leftJoin('r.IncorrectForm f')
			->leftJoin('f.CorrectWord')
			->fetchArray();
	}
}
