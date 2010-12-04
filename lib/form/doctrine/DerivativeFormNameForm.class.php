<?php

/**
 * DerivativeFormName form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id$
 */
class DerivativeFormNameForm extends DerivativeFormForm
{
	public function configure()
	{
		$this->useFields(array('name_broken'));
	}
}
