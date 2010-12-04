<?php

/**
 * AbstractWord
 *
 *
 * @package    rechnik
 * @subpackage model
 * @author     borislav
 * @version    SVN: $Id$
 */
class AbstractWord extends BaseAbstractWord
{
	public function updateNameBroken()
	{
		$this->name_broken = BgHyphenatorConstructor::getHyphenator()->getSyllables($this->name);
	}

	public function updateNameCondensed()
	{
		$this->name_condensed = MyI18nToolkit::condenseWord($this->name);
	}
}
