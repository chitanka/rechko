<?php

class WordRevisionTable extends RevisionTable
{
	public function getRecentWithObject()
	{
		return $this->createQuery('r')
			->leftJoin('r.Word')
			->leftJoin('r.User')
			->fetchArray();
	}
}
