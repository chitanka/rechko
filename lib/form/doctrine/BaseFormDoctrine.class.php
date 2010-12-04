<?php

/**
 * Project form base class.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class BaseFormDoctrine extends sfFormDoctrine
{
	public function setup()
	{
	}

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
