<?php

/**
 * WordEtymology form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 */
class WordEtymologyForm extends WordForm
{
	public function configure()
	{
		$this->useFields(array('etymology'));
	}
}
