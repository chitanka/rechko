<?php

/**
 * IncorrectForm
 *
 *
 * @package    rechnik
 * @subpackage model
 * @author     borislav
 * @version    SVN: $Id$
 */
class IncorrectForm extends BaseIncorrectForm
{
	protected $isLoggable = false;

	public function postInsert($event)
	{
		#try {sfContext::getInstance()->getLogger()->info(sprintf('=== %s', __METHOD__));}catch(sfException $e){}
		if ($this->isLoggable) {
			$this->getRevisionTable()->fromObjectInsert($this);
		}
		#try {sfContext::getInstance()->getLogger()->info(sprintf('<<< %s', __METHOD__));}catch(sfException $e){}
	}

	public function preUpdate($event)
	{
		#try {sfContext::getInstance()->getLogger()->info(sprintf('=== %s', __METHOD__));}catch(sfException $e){}
		if ($this->isLoggable) {
			$this->getRevisionTable()->fromObjectUpdate($this);
		}
		#try {sfContext::getInstance()->getLogger()->info(sprintf('<<< %s', __METHOD__));}catch(sfException $e){}
	}

	public function postDelete($event)
	{
		#try {sfContext::getInstance()->getLogger()->info(sprintf('=== %s: %s', __METHOD__, min_backtrace()));}catch(sfException $e){}
		if ($this->isLoggable) {
			$this->getRevisionTable()->fromObjectDelete($this);
		}
		#try {sfContext::getInstance()->getLogger()->info(sprintf('<<< %s', __METHOD__));}catch(sfException $e){}
	}

	public function getRevisionTable()
	{
		return Doctrine_Core::getTable('IncorrectFormRevision');
	}


	public function setLoggable($isLoggable)
	{
			$this->isLoggable = $isLoggable;

			return $this;
	}
}
