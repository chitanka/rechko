<?php

/**
 * word actions.
 *
 * @package    rechnik
 * @subpackage word
 * @author     borislav
 * @version    SVN: $Id$
 */
class wordActions extends sfActions
{

	/**
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		$this->initQuery($request);
		$logSearch = (bool) $request->getParameter('log', 1);

		if ($request->isXmlHttpRequest()) {
			$resp = '';
			if ($this->query) {
				$words = Doctrine_Core::getTable('Word')->getNamesByPrefix($this->query);
				$resp = $this->buildAcResponse($words);
			}

			return $this->renderText($resp);
		}

		if ($this->query) {
			list($this->words, $this->words_count) = $this->lookUpWords($this->query, $logSearch);

			list($this->derivative_forms, $this->derivative_forms_count) = $this->lookUpDerivativeForms($this->query, $logSearch);

			$this->no_results = ($this->words_count + $this->derivative_forms_count) == 0;

			$this->incorrect_forms_count = 0;

			if ($this->no_results) {
				list($this->incorrect_forms, $this->incorrect_forms_count) = $this->lookUpIncorrectForms($this->query, $logSearch);

				$this->no_results = $this->incorrect_forms_count == 0;

				if ($this->no_results) {
					$this->similar_words = $this->lookUpSimilar($this->query);

					$this->getResponse()->setStatusCode(404);
				}
			}
		}
	}

	public function executeIndexOld(sfWebRequest $request)
	{
		return $this->redirect( str_replace('/bg/', '/w/', $request->getUri()), 301 );
	}

	public function executeTranslation(sfWebRequest $request)
	{
		$this->translation = Doctrine_Core::getTable('WordTranslation')->getByWordAndLang($request->getParameter('word_id'), $request->getParameter('lang'));

		if ($request->isXmlHttpRequest()) {
			return $this->renderPartial('translation', array('translation' => $this->translation));
		}
	}


	protected function initQuery(sfWebRequest $request)
	{
		$this->query = $request->getParameter('query'); // thru pretty url
		if (empty($this->query)) {
			$this->query = $request->getParameter('q'); // thru form (class url parameter)
		} else {
			$request->setParameter('q', $this->query);
		}

		$this->query = MyI18nToolkit::latcyr($this->query);
	}


	/**
	* @param string $query      Request query
	* @param bool   $logSearch  Should this request be logged
	*/
	protected function lookUpWords($query, $logSearch)
	{
		$table = Doctrine_Core::getTable('Word');
		$words = $table->getByName($query);
		$count = count($words);

		if ($logSearch && $count && $this->getUser()->isFirstSearchOf($words[0]['name'])) {
			$table->incrementSearchCount($words[0]['id']);
		}

		return array($words, $count);
	}

	/**
	* @param string $query      Request query
	* @param bool   $logSearch  Should this request be logged
	*/
	protected function lookUpDerivativeForms($query, $logSearch)
	{
		$table = Doctrine_Core::getTable('DerivativeForm');
		$forms = $table->getByName($query);
		$count = count($forms);

		if ($logSearch && $count && $this->getUser()->isFirstSearchOf($forms[0]['name'])) {
			$table->incrementSearchCount($forms[0]['id']);
		}

		return array($forms, $count);
	}


	/**
	* @param string $query      Request query
	* @param bool   $logSearch  Should this request be logged
	*/
	protected function lookUpIncorrectForms($query, $logSearch)
	{
		$table = Doctrine_Core::getTable('IncorrectForm');
		$forms = $table->getByNameWithCorrectWord($query);
		$count = count($forms);

		if ($logSearch && $count && $this->getUser()->isFirstSearchOf($forms[0]['name'])) {
			$table->incrementSearchCount($forms[0]['id']);
		}

		return array($forms, $count);
	}

	/**
	* Find similar words or derivative forms for a query
	* @param string $query      Request query
	*/
	protected function lookUpSimilar($query)
	{
		$similar = Doctrine_Core::getTable('DerivativeForm')->getSimilar($query);

		return $similar;
	}


	public function executeRandom()
	{
		$this->redirect('@word?query='.Doctrine_Core::getTable('Word')->getRandomWord());
	}



	public function buildAcResponse($words)
	{
		$arr = array();
		foreach ($words as $word) {
			$arr[] = $word['name'] .'|'. $word['name'];
		}

		return implode("\n", $arr);
	}


	public function executeNewWord(sfWebRequest $request)
	{
		$this->form = new WordForm();
		$this->form->useFields(array(
			'name_stressed',
			'meaning',
			'etymology',
			'synonyms',
			'type_id',
		));
	}

	public function executeCreateWord(sfWebRequest $request)
	{
		$form = new WordForm;
		$form->bindRequest($request);

		if ($form->isValid()) {
			$form->save();
			$object = $form->getObject();

			if ($request->isXmlHttpRequest()) {
				return $this->renderPartial('word_with_header', array('word' => $object));
			}

			$this->redirect('@word?query='. $object['name']);
		}

		$this->setTemplate('new');
	}


	public function executeEditWord(sfWebRequest $request)
	{
		$this->word = $this->getRoute()->getObject();
		$this->forward404Unless($this->word);

		$this->form = new WordForm($this->word);
	}

	public function executeUpdateWord(sfWebRequest $request)
	{
		$this->executeEditWord($request);
		$this->form->bindRequest($request);

		if ($this->form->isValid()) {
			$this->form->save();
			$object = $this->form->getObject();

			if ($request->isXmlHttpRequest()) {
				return $this->renderPartial('word_with_header', array('word' => $object));
			}

			$this->redirect('@word?query='. $object['name']);
		}

		$this->setTemplate('edit');
	}


	public function executeDeleteWord()
	{
		$this->word = $this->getRoute()->getObject();
		$this->forward404Unless($this->word);

		$this->word->delete();
		return $this->renderText( $this->word->exists() );
	}


	public function executeEditMeaning(sfWebRequest $request)
	{
		$this->editField($request, 'WordMeaning');
	}

	public function executeUpdateMeaning(sfWebRequest $request)
	{
		return $this->updateField($request, 'WordMeaning', 'meaning');
	}


	public function executeEditEtymology(sfWebRequest $request)
	{
		$this->editField($request, 'WordEtymology');
	}

	public function executeUpdateEtymology(sfWebRequest $request)
	{
		return $this->updateField($request, 'WordEtymology', 'etymology');
	}


	public function executeEditSynonyms(sfWebRequest $request)
	{
		$this->editField($request, 'WordSynonyms');
	}

	public function executeUpdateSynonyms(sfWebRequest $request)
	{
		return $this->updateField($request, 'WordSynonyms', 'synonyms');
	}


	public function executeEditType(sfWebRequest $request)
	{
		$this->editField($request, 'WordTypeId');
	}

	public function executeUpdateType(sfWebRequest $request)
	{
		return $this->updateField($request, 'WordTypeId', 'type');
	}


	public function executeEditNameStressed(sfWebRequest $request)
	{
		$this->editField($request, 'WordNameStressed');
	}

	public function executeUpdateNameStressed(sfWebRequest $request)
	{
		return $this->updateField($request, 'WordNameStressed', 'name_stressed');
	}


	public function executeNewIncorrectForm(sfWebRequest $request)
	{
		$iform = new IncorrectForm;
		$iform['correct_word_id'] = $request->getParameter('word_id');
		$this->form = new IncorrectFormForm($iform);
	}

	public function executeCreateIncorrectForm(sfWebRequest $request)
	{
		$form = new IncorrectFormForm;
		$form->bindRequest($request);

		if ($form->isValid()) {
			$form->save();
			$object = $form->getObject();

			if ($request->isXmlHttpRequest()) {
				return $this->renderPartial('incorrect_form', array('form' => $object));
			}

			$this->redirect('@word?query='. $object['CorrectWord']['name']);
		}
	}

	public function executeEditIncorrectForm()
	{
		$object = $this->getRoute()->getObject();
		$this->forward404Unless($object);

		$this->form = new IncorrectFormNameForm($object);
	}

	public function executeUpdateIncorrectForm(sfWebRequest $request)
	{
		$this->executeEditIncorrectForm();

		$this->form->bindRequest($request);

		if ($this->form->isValid()) {
			$this->form->save();
			$object = $this->form->getObject();

			if ($request->isXmlHttpRequest()) {
				return $this->renderText($object['name']);
			}

			$this->redirect('@word?query='. $object['CorrectWord']['name']);
		}
	}

	public function executeDeleteIncorrectForm()
	{
		$this->incorrect_form = $this->getRoute()->getObject();
		$this->forward404Unless($this->incorrect_form);

		$this->incorrect_form->delete();
		return $this->renderText( $this->incorrect_form->exists() );
	}






	public function executeNewTranslation(sfWebRequest $request)
	{
		$form = new WordTranslation;
		$form['word_id'] = $request->getParameter('word_id');
		$form['lang'] = $request->getParameter('lang');
		$this->form = new WordTranslationForm($form);
	}

	public function executeCreateTranslation(sfWebRequest $request)
	{
		$form = new WordTranslationForm;
		$form->bindRequest($request);

		if ($form->isValid()) {
			$form->save();
			$object = $form->getObject();

			if ($request->isXmlHttpRequest()) {
				return $this->renderPartial('translation', array('translation' => $object));
			}

			$this->redirect('@word?query='. $object['Word']['name']);
		}
	}

	public function executeEditTranslation()
	{
		$object = $this->getRoute()->getObject();
		$this->forward404Unless($object);

		$this->form = new WordTranslationForm($object);
	}

	public function executeUpdateTranslation(sfWebRequest $request)
	{
		$this->executeEditTranslation();

		$this->form->bindRequest($request);

		if ($this->form->isValid()) {
			$this->form->save();
			$object = $this->form->getObject();

			if ($request->isXmlHttpRequest()) {
				return $this->renderText($object['name']);
			}

			$this->redirect('@word?query='. $object['Word']['name']);
		}
	}








	public function executeEditDerivativeForm()
	{
		$object = $this->getRoute()->getObject();
		$this->forward404Unless($object);

		$this->form = new DerivativeFormNameForm($object);
	}

	public function executeUpdateDerivativeForm(sfWebRequest $request)
	{
		$this->executeEditDerivativeForm();

		$this->form->bindRequest($request);

		if ($this->form->isValid()) {
			$this->form->save();
			$object = $this->form->getObject();

			if ($request->isXmlHttpRequest()) {
				return $this->renderPartial('derivative_form_link', array('form' => $object));
			}

			$this->redirect('@word?query='. $object['BaseWord']['name']);
		}
	}


	/**
	* Template function for executeEdit{Field}s
	*
	* @param sfWebRequest $request
	* @param string $fieldKey          A key representing the edited object, e.g. WordMeaning
	*/
	protected function editField(sfWebRequest $request, $fieldKey)
	{
		$this->word = $this->getRoute()->getObject();
		$this->forward404Unless($this->word);

		$formClass = sprintf('%sForm', $fieldKey); // e.g. WordMeaningForm
		$this->form = new $formClass($this->word);
	}

	/**
	* Template function for executeUpdate{Field}s
	*
	* @param sfWebRequest $request
	* @param string $fieldKey          A key representing the updated object, e.g. WordMeaning
	* @param string $responsePartial   A partial which should be used for the ajax response
	*/
	public function updateField(sfWebRequest $request, $fieldKey, $responsePartial)
	{
		$this->editField($request, $fieldKey);

		$this->form->bindRequest($request);

		if ($this->form->isValid()) {
			$this->form->save();

			if ($request->isXmlHttpRequest()) {
				return $this->renderPartial($responsePartial, array('word' => $this->word));
			}

			$this->redirect('@word?query='. $this->word['name']);
		}
	}

}
