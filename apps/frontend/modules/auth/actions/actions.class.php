<?php

/**
 * auth actions.
 *
 * @package    rechnik
 * @subpackage auth
 * @author     borislav
 * @version    SVN: $Id$
 */
class authActions extends BasesfPHPOpenIDAuthActions
{
	/**
	* Executes index action
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
	}

	public function executeSignin(sfWebRequest $request)
	{
		$user = $this->getUser();
		if ($user->isAuthenticated()) {
			return $this->redirect('@homepage');
		}

		$this->form = new OpenIdSigninForm;
		$this->redirect = false;

		if ($request->isMethod('post')) {
			$this->form->bindRequest($request);
			if ($this->form->isValid()) {
				$this->redirect = $this->getRedirectHtml($this->form->getValue('openid'));
			}
		} else {
			$user->setReferer($request->getReferer());
		}

		$this->google_form = clone $this->form;
		$this->google_form->setCustomOpenId(sfConfig::get('app_openid_google'));
		$this->yahoo_form = clone $this->form;
		$this->yahoo_form->setCustomOpenId(sfConfig::get('app_openid_yahoo'));
/*
		if ($request->isMethod('post')) {
			if ($this->form->isValid()) {
			}
		} else {
			if ($request->isXmlHttpRequest()) {
				$this->getResponse()->setHeaderOnly(true);
				$this->getResponse()->setStatusCode(401);

				return sfView::NONE;
			}

			$module = sfConfig::get('sf_login_module');
			if ($this->getModuleName() != $module) {
				return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
			}

			$this->getResponse()->setStatusCode(401);
		}*/
	}


	public function executeAutoSignin(sfWebRequest $request)
	{
		$user = $this->getUser();
		$openid = $user->getAttribute('openid_identity');
		$redirect = $this->getRedirectHtml($openid, true);
		if ($redirect['success']) {
			$this->getUser()->signIn(Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $openid), true);
		}

		$this->redirect($user->getReferer());
	}


	public function executeSignout(sfWebRequest $request)
	{
		$this->getUser()->signOut();
		$this->getResponse()->setCookie('openid_identity', '');

		$this->redirect('@homepage');
	}


	/**
	* @param array $openidValidationResult
	* 'result'   => 'result code',
	* 'message'  => 'an optional message',
	* 'identity' => 'the user's identity (http://user.myopenid.com)',
	* 'userData' => array of user fields values
	*     'fullname' => array('the fullname', 'another fullname')
	*     'email' => array('the email')
	*     ...
	* 'PAPEResp' => 'an Auth_OpenID_PAPE_Response object (null if the provider didn't send a PAPE response)'
	*/
	public function openIDCallback($openidValidationResult)
	{
		$openid = rtrim($openidValidationResult['identity'], '/');
		$this->getResponse()->setCookie('openid_identity', $openid, sprintf('+%d days', sfConfig::get('app_openid_cookie_expire', 30)));

		$user = Doctrine_Core::getTable('sfGuardUser')->findOneBy('username', $openid);
		if ( ! $user) {
			$user = new sfGuardUser;
			$user->username = $openid;
			$user->Profile->realname = $this->getRealnameFromOpenidResult($openidValidationResult['userData'], $openid);
			$user->Profile->email = $openidValidationResult['userData']['email'][0];
			$user->save();
		}

		$this->getUser()->signIn($user, true);

		$signinUrl = sfConfig::get('app_success_signin_url', $this->getUser()->getReferer());

		$this->redirect('' != $signinUrl ? $signinUrl : '@homepage');
	}


	protected function getRealnameFromOpenidResult($result, $openid)
	{
		if ( isset($result['fullname']) ) {
			$realname = $result['fullname'][0];
		} else if ( isset($result['firstname']) && isset($result['lastname']) ) {
			$realname = $result['firstname'][0] . ' ' . $result['lastname'][0];
		} else {
			$realname = $openid;
		}

		return $realname;
	}


	public function executeOpenidError(sfWebRequest $request)
	{
		$this->getResponse()->setCookie('openid_identity', '');
	}
}
