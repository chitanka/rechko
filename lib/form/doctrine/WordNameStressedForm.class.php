<?php

/**
 * Word form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 */
class WordNameStressedForm extends WordForm
{
	public function configure()
	{
		parent::configure();
		$this->useFields(array('name_stressed'));
	}
}
