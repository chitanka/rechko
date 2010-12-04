<?php

class WordTypeTable extends Doctrine_Table
{
	public function getListAllQuery()
	{
		return $this->createQuery()
			->orderBy('speech_part, name');
	}
}
