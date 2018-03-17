<?php
class bmValidatorSpam extends sfValidatorBase
{
	private $_maxLinkCount = 0;

// 	protected function configure($options = array(), $messages = array())
// 	{
// 		parent::configure($options, $messages);
// 	}

	protected function doClean($value)
	{
		if (strpos($value, '<a') !== false) {
			throw new sfValidatorError($this, 'html not allowed: a');
		}
		if (strpos($value, '[url') !== false) {
			throw new sfValidatorError($this, 'bbcode not allowed: url');
		}
		if (strpos($value, '[link') !== false) {
			throw new sfValidatorError($this, 'bbcode not allowed: link');
		}
		if (substr_count($value, 'http') > $this->_maxLinkCount) {
			throw new sfValidatorError($this, "link count exceeds $this->_maxLinkCount");
		}

		return $value;
	}
}
