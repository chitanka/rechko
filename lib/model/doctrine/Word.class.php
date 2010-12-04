<?php

/**
 * Word
 *
 *
 * @package    rechnik
 * @subpackage model
 * @author     borislav
 * @version    SVN: $Id$
 */
class Word extends BaseWord
{
	const MAX_INCORRECT_FORMS = 50;


	public function incrementSearchCount()
	{
		$this->search_count++;
		$this->save();

		return $this;
	}

	public function preInsert($event)
	{
		#try {sfContext::getInstance()->getLogger()->info(sprintf('=== %s', __METHOD__));}catch(sfException $e){}
		if ($this->name == '') {
			$this->name = MyI18nToolkit::removeAccent($this->name_stressed);
		}

		if ($this->IncorrectForms->count() == 0) {
			$this->updateIncorrectForms();
		}

		if ($this->DerivativeForms->count() == 0) {
			$this->updateDerivativeForms();
		}

		if (empty($this->name_broken)) {
			$this->updateNameBroken();
		}

		$this->updateNameCondensed();
		#try {sfContext::getInstance()->getLogger()->info(sprintf('<<< %s', __METHOD__));}catch(sfException $e){}
	}


	public function postInsert($event)
	{
		#try {sfContext::getInstance()->getLogger()->info(sprintf('=== %s', __METHOD__));}catch(sfException $e){}
		$this->getRevisionTable()->fromObjectInsert($this);
		#try {sfContext::getInstance()->getLogger()->info(sprintf('<<< %s', __METHOD__));}catch(sfException $e){}
	}


	public function preUpdate($event)
	{
		#try {sfContext::getInstance()->getLogger()->info(sprintf('=== %s', __METHOD__));}catch(sfException $e){}
		$this->getRevisionTable()->fromObjectUpdate($this);

		$modified = $this->getModified();

		if (isset($modified['deleted_at'])) {
			// record soft-deleted, nothing to do here
			#try {sfContext::getInstance()->getLogger()->info(sprintf('<<<--- %s', __METHOD__));}catch(sfException $e){}
			return;
		}

		if (isset($modified['type_id'])) {
			$this->updateDerivativeForms();
		}

		if (isset($modified['name_stressed'])) {
			$name = MyI18nToolkit::removeAccent($this->name_stressed);
			if ($this->name != $name) {
				$this->name = $name;
				$this->updateNameBroken();
				$this->updateNameCondensed();
				$this->updateDerivativeForms();
			}
			if ($this->IncorrectForms->count() == 0) {
				$this->updateIncorrectForms();
			}
		}

		#try {sfContext::getInstance()->getLogger()->info(sprintf('<<< %s', __METHOD__));}catch(sfException $e){}
	}


	public function postDelete($event)
	{
		#try {sfContext::getInstance()->getLogger()->info(sprintf('=== %s', __METHOD__));}catch(sfException $e){}
		$this->getRevisionTable()->fromObjectDelete($this);
		$this->DerivativeForms->delete();
		foreach ($this->IncorrectForms as $form) {
			$form->setLoggable(false)->delete();
		}
		#try {sfContext::getInstance()->getLogger()->info(sprintf('<<< %s', __METHOD__));}catch(sfException $e){}
	}


	public function getRevisionTable()
	{
		return Doctrine_Core::getTable('WordRevision');
	}


	public function updateIncorrectForms($overwrite = false)
	{
		if ($overwrite) {
			$this->IncorrectForms->clear();
		}

		$names = IncorrectFormsGenerator::getIncorrectForms($this->name_stressed);
		if ( count($names) > self::MAX_INCORRECT_FORMS ) {
			return;
		}

		foreach ($names as $name) {
			$this->addIncorrectForm($name, false);
		}
	}


	public function addIncorrectForm($name, $loggable = true)
	{
		$form = new IncorrectForm;
		$form['name'] = $name;
		$form->setLoggable($loggable);
		$this->IncorrectForms[] = $form;
	}


	public function updateDerivativeForms($overwrite = true)
	{
		if ($overwrite) {
			$this->DerivativeForms->clear();
		}
		$forms = DerivativeFormsGenerator::getDerivativeForms($this);
		$this->fillDerivativeForms($forms);
	}

	public function fillDerivativeForms($forms)
	{
		foreach ($forms as $description => $names) {
			foreach ((array) $names as $name) {
				$form = new DerivativeForm;
				$form->fromArray(array(
					'name'          => $name,
					'description'   => $description,
					'is_infinitive' => ($name == $this->name),
				));
				$this->DerivativeForms[] = $form;
			}
		}
	}


	public function isMissingStress()
	{
		return empty($this->name_stressed)
			|| ($this->name == $this->name_stressed && $this->hasSeveralSyllables());
	}

	public function hasOneSyllable()
	{
		return $this->name == $this->name_broken;
	}

	public function hasSeveralSyllables()
	{
		return $this->name != $this->name_broken;
	}
}
