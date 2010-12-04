<?php

/**
 * WordType form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 */
class WordTypeIdForm extends WordForm
{
	public function configure()
	{
		parent::configure();

		$this->useFields(array(
			'type_id',
		));
	}
}
