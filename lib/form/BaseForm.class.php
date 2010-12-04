<?php

/**
 * Base project form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id$
 */
class BaseForm extends sfFormSymfony
{

	/**
	* Bind a request to the form.
	* http://kriswallsmith.net/post/109952125/waiting-for-the-metro-thinking-about-forms
	* @param $request A request
	*/
	public function bindRequest(sfWebRequest $request)
	{
		$this->bind(
			$request->getParameter($this->getName()),
			$request->getFiles($this->getName())
		);

		return $this;
	}
}
