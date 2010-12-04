<?php

class WordTranslationTable extends Doctrine_Table
{
	public function getByWordAndLang($wordId, $lang)
	{
		return $this->createQuery()
			->where('word_id = ? AND lang = ?', array($wordId, $lang))
			->fetchOne();
	}
}