<?php

/**
 * DerivativeForm
 *
 *
 * @package    rechnik
 * @subpackage model
 * @author     borislav
 * @version    SVN: $Id$
 */
class DerivativeForm extends BaseDerivativeForm
{
	public function preInsert($event)
	{
		$this->updateNameBroken();
		$this->updateNameCondensed();
	}

	public function preUpdate($event)
	{
		$modified = $this->getModified();
		if (isset($modified['name_broken'])) {
			$this->name = MyI18nToolkit::glueBroken($this->name_broken);
		}
	}

}
