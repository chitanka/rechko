<?php
class SearchForm extends BaseForm
{
	public function configure()
	{
		$this->setWidgets(array(
			'q'  => new sfWidgetFormInput(array(), array(
				'accesskey' => 'т',
				'title'     => 'Клавиш за достъп: Т',
			)),
		));

		$this->setValidators(array(
			'q'  => new sfValidatorPass,
		));

		$this->widgetSchema->setLabels(array(
			'q'  => 'Дума',
		));

		$this->disableLocalCSRFProtection();
	}

}
