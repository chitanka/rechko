<?php

/**
 * revision actions.
 *
 * @package    rechnik
 * @subpackage revision
 * @author     borislav
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class revisionActions extends sfActions
{
 /**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		$this->word_revs = Doctrine_Core::getTable('WordRevision')->getRecentWithObject();
		$this->iform_revs = Doctrine_Core::getTable('IncorrectFormRevision')->getRecentWithObject();
	}
}
