<?php

/**
 * IncorrectFormName form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id$
 */
class IncorrectFormNameForm extends IncorrectFormForm
{
	public function configure()
	{
		$this->useFields(array('name'));
	}
}
