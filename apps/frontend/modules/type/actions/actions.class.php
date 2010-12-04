<?php

/**
 * type actions.
 *
 * @package    rechnik
 * @subpackage type
 * @author     borislav
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class typeActions extends sfActions
{
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
	}


	public function executeList(sfWebRequest $request)
	{
		$this->type = $this->getRoute()->getObject();
		$this->forward404Unless($this->type);

		$this->pager = new sfDoctrinePager('Word', sfConfig::get('app_list_max_words', 30));
		$this->pager->setQuery(Doctrine_Core::getTable('Word')->getByTypeIdQuery($this->type['id']));
		$this->pager->setPage($request->getParameter('page', 1));
		$this->pager->init();
	}
}
