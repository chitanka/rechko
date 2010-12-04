<?php

/**
 *
 * @package    rechnik
 * @subpackage form
 * @author     borislav
 */
class OpenIdSigninForm extends BaseForm
{
	public function configure()
	{
		$this->widgetSchema['openid'] = new sfWidgetFormInputText(array(), array(
			'class' => 'openid'
		));

		$this->validatorSchema['openid'] = new sfValidatorAnd(array(
			new sfPHPOpenIdValidator,
			new sfValidatorCallback(array(
				'callback' => array($this, 'validateOpenid')
			))
		));

		$this->widgetSchema->setLabels(array(
			'openid' => 'OpenID'
		));

		$this->widgetSchema->setNameFormat('signin[%s]');
	}


	public function validateOpenid($validator, $value)
	{
		return rtrim($value, '/');
	}


	public function setCustomOpenId($openid)
	{
		$this->widgetSchema['openid'] = new sfWidgetFormInputHidden();
		$this->setDefault('openid', $openid);
	}
}
