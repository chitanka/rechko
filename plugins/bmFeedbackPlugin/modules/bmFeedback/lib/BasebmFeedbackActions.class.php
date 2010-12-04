<?php

/**
 * Base actions for the bmFeedbackPlugin feedback module.
 *
 * @package     bmFeedbackPlugin
 * @subpackage  feedback
 * @author      borislav
 * @version     SVN: $Id$
 */
abstract class BasebmFeedbackActions extends sfActions
{
	/**
	* Show the feedback form and process a POST request if any.
	*
	* @param sfRequest $request A request object
	*/
	public function executeIndex(sfWebRequest $request)
	{
		$this->form = new FeedbackForm;

		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()));

			if ($this->form->isValid()) {
				$this->processFeedback($this->form->getValues());
				$this->redirect('@feedback_thankyou');
			}
		}
	}


	public function executeThankyou()
	{
	}


	protected function processFeedback($data)
	{
		if ('' == $data['name']) $data['name'] = 'Anonymous';
		if ('' == $data['email']) $data['email'] = 'anon@anon.net';

		$message = $this->getMailer()
			->compose(
				array($data['email'] => $data['name']),
				sfConfig::get('app_feedback_email'),
				sfConfig::get('app_feedback_subject', 'Feedback from your site'),
				$data['message']
			)
			->setReplyTo(array($data['email'] => $data['name']));

		$this->getMailer()->send($message);
	}
}
