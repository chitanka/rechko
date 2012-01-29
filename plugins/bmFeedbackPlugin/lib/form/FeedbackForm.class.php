<?php
class FeedbackForm extends BaseForm
{

	public function configure()
	{
		$this->setWidgets(array(
			'name'    => new sfWidgetFormInput(),
			'email'   => new sfWidgetFormInput(),
			'message' => new sfWidgetFormTextarea(),
		));

		$messages = sfConfig::get('app_feedback_form');

		$this->setValidators(array(
			'name'    => new sfValidatorString(array('required' => false)),
			'email'   => new sfValidatorEmail(
				array('required' => false),
				array('invalid' => $messages['email']['invalid_msg'])),
			'message' => new sfValidatorAnd(array(
				new sfValidatorString(
					array('min_length' => 50),
					array(
						'required' => $messages['message']['required_msg'],
						'min_length' => $messages['message']['min_length_msg'],
					)
				),
				new bmValidatorSpam(),
			)),
		));

		$this->widgetSchema->setLabels(array(
			'name'    => $messages['name']['label'],
			'email'   => $messages['email']['label'],
			'message' => $messages['message']['label'],
		));

		$this->widgetSchema->setNameFormat('feedback[%s]');

		$this->disableLocalCSRFProtection();
	}

}
