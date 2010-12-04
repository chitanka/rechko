<?php

class myUser extends sfGuardSecurityUser
{

	public function getId()
	{
		return $this->getGuardUser()->getId();
	}

	public function getRealname()
	{
		return $this->getProfile()->getRealname();
	}

	public function getEmail()
	{
		return $this->getProfile()->getEmail();
	}

	public function isFirstSearchOf($query)
	{
		$queries = $this->getAttribute('queries');
		if ( isset($queries[$query]) ) {
			return false;
		}

		$queries[$query] = true;
		$this->setAttribute('queries', $queries);

		return true;
	}

	public function isEditor()
	{
		return $this->hasCredential('edit');
	}

	public function isFullEditor()
	{
		return $this->hasCredential('delete');
	}
}
