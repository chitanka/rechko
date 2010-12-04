<?php

/**
 * main components.
 *
 * @package    rechnik
 * @subpackage main
 * @author     borislav
 */
class wordComponents extends sfComponents
{

	public function executeSearch(sfWebRequest $request)
	{
		$this->form = new SearchForm;
		$this->form->bind(array('q' => $request->getParameter('q')));
	}

	public function executeMostSearchedWords()
	{
		$this->words = Doctrine_Core::getTable('Word')->getMostSearched();
	}

	public function executeMostSearchedDerivativeForms()
	{
		$this->forms = Doctrine_Core::getTable('DerivativeForm')->getMostSearched();
	}

	public function executeMostSearchedIncorrectForms()
	{
		$this->forms = Doctrine_Core::getTable('IncorrectForm')->getMostSearched();
	}
}
