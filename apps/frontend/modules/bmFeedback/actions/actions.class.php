<?php
require_once(sfConfig::get('sf_plugins_dir').'/bmFeedbackPlugin/modules/bmFeedback/lib/BasebmFeedbackActions.class.php');

/**
* feedback actions.
*
* @package    rechnik
* @subpackage feedback
* @author     borislav
* @version    SVN: $Id$
*/
class bmFeedbackActions extends BasebmFeedbackActions
{
	/**
	*/
	public function executeIndex(sfWebRequest $request)
	{
		parent::executeIndex($request);

		$user = $this->getUser();
		if ($user->isAuthenticated()) {
			$this->form->setDefaults(array(
				'name'  => $user->getRealname(),
				'email' => $user->getEmail(),
			));
		}
	}

}

