<?php

/**
 * Word form.
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 * @version    SVN: $Id$
 */
class WordForm extends BaseWordForm
{
	public function configure()
	{
		$word = $this->getObject();
		if (empty($word['name_stressed'])) {
			$word['name_stressed'] = $word['name'];
		}

		$this->widgetSchema['type_id'] = new sfWidgetFormDoctrineChoice(array(
			'model' => 'WordType',
			'query' => Doctrine::getTable('WordType')->getListAllQuery(),
			'add_empty' => true
		));

		$this->widgetSchema->setLabels(array(
			'name_stressed' => 'Име с ударение',
			'meaning' => 'Значение',
			'synonyms' => 'Синоними',
			'type_id' => 'Тип',
			'classification' => 'Класификация',
			'pronounciation' => 'Произношение',
			'etymology' => 'Етимология',
			'related_words' => 'Сродни думи',
			'derived_words' => 'Производни думи',
		));
	}
}
