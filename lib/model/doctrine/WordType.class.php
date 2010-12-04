<?php

/**
 * WordType
 *
 *
 * @package    rechnik
 * @subpackage model
 * @author     borislav
 * @version    SVN: $Id$
 */
class WordType extends BaseWordType
{
	public function __toString()
	{
		return "$this->name — $this->speech_part ($this->example_word)";
	}
}
