<?php

/**
 * Word form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 */
class WordMeaningForm extends WordForm
{
	public function configure()
	{
		$this->useFields(array('meaning'));
	}
}
