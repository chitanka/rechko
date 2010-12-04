<?php

/**
 * user actions.
 *
 * @package    rechnik
 * @subpackage user
 * @author     borislav
 * @version    SVN: $Id$
 */
class userActions extends sfActions
{
 /**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		$this->user = Doctrine_Core::getTable('sfGuardUser')->getBySlug($request->getParameter('slug'));
		$this->forward404Unless($this->user);
	}
}
