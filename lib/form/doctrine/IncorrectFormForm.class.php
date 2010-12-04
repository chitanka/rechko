<?php

/**
 * IncorrectForm form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id$
 */
class IncorrectFormForm extends BaseIncorrectFormForm
{
	public function configure()
	{
		$this->widgetSchema['correct_word_id'] = new sfWidgetFormInputHidden;

		$this->disableCSRFProtection();
	}
}
