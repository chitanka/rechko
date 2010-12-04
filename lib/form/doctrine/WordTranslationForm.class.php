<?php

/**
 * WordTranslation form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id$
 */
class WordTranslationForm extends BaseWordTranslationForm
{
	public function configure()
	{
		$this->widgetSchema['word_id'] = new sfWidgetFormInputHidden;
		$this->widgetSchema['lang'] = new sfWidgetFormInputHidden;

		$this->disableCSRFProtection();
	}

	public function hideLang()
	{
		$this->widgetSchema['lang'] = new sfWidgetFormInputHidden;
	}
}
