<?php

/**
 * Word form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 */
class WordSynonymsForm extends WordForm
{
	public function configure()
	{
		$this->useFields(array('synonyms'));
	}
}
