<?php

/*
 * This file is part of sfPHPOpenIDPlugin.
 * (c) 2009 GenOuest Platform <support@genouest.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfPHPOpenID class.
 *
 * @package    sfPHPOpenIDPlugin
 * @author     GenOuest Platform <support@genouest.org>
 * @version    SVN: $Id: sfPHPOpenID.class.php 18089 2009-05-09 06:36:09Z fabien $
 */

/**
 * This class is the base class for modules actions classes.
 */

class BasesfPHPOpenIDAuthActions extends sfActions
{

  /*
   * Check the given OpenID and returns html code for redirection if the identity is valid.
   *
   * @param $identity     The OpenID the user want to login with
   * @param $immediate    Should this be an immediate login (ie provider should answer yes or no without showing any form)
   * @param $submitLabel  The value of the submit button that will be displayed if javascript is disabled. Optional, default is 'Continue'.
   * @param $linkLabel    The label of the link that will be displayed if javascript is disabled. Optional, default is 'Click here to continue login with OpenID.'.
   * @param $linkAttrs    An array of attributes of the link that will be displayed if javascript is disabled. Optional.
   *
   * @returns array(
   *               'success' => true or false,
   *               'error' => 'An error message if success is false',
   *               'htmlCode' => 'The html code performing redirection (html link or form, hidden if javascript is on). To be included in the template. Empty if success is false.'
   *               )
   */
  public function getRedirectHtml($identity, $immediate = false, $submitLabel = '', $linkLabel = '', $linkAttrs = array()) {

    if (empty($linkLabel))
      $linkLabel = 'Click here to continue login with OpenID.';

    $result = array('success' => false,
                    'error' => '',
                    'htmlCode' => '');

		$openid = new sfPHPOpenID();
		$openid->setIdentity($identity);

		$process_url = $this->getController()->genUrl('@openid_finishauth', true);
		$openid->setApprovedURL($process_url); // Script which handles a response from OpenID Server

		$trust_root = $this->getController()->genUrl('@homepage', true);
		$openid->SetTrustRoot($trust_root);

		$this->setOpenIDRequestParameters($openid); // Call a function to customize the openid object from the app

		$nextStep = $openid->getRedirectURL($immediate, $submitLabel);

		if (($nextStep['type'] == 'url') && (!empty($nextStep['content']))) {
		  // Using OpenID 1 => redirection using URL
		  $result['success'] = true;

	    $result['htmlCode'] = "<script type=\"text/javascript\">var transiting = true;document.location.href = \"".$nextStep['content']."\"</script>"; // auto redirect if js on
	    $result['htmlCode'] .= "<a href=\"".$nextStep['content']."\" ";
	    unset($linkAttrs['href']);
	    $linkAttrs['id'] = 'openid_message';

      foreach ($linkAttrs as $name => $attr) {
          $result['htmlCode'] .= sprintf(" %s=\"%s\"", $name, $attr);
      }
	    $result['htmlCode'] .= ">$linkLabel</a>";
		  $result['htmlCode'] .= "<script type=\"text/javascript\">document.getElementById('".$linkAttrs['id']."').style.display = 'none';</script>"; // Hide the link if js on (=auto redirect)
		}
		else if (($nextStep['type'] == 'form') && (!empty($nextStep['content']))) {
		  // Using OpenID 2 => redirection using a form
		  $result['success'] = true;

		  $result['htmlCode'] = $nextStep['content'];
	    $result['htmlCode'] .= "<script type=\"text/javascript\">document.getElementById('openid_message').style.display = 'none';</script>"; // Auto submit if js on
	    $result['htmlCode'] .= "<script type=\"text/javascript\">var transiting = true;document.getElementById('openid_message').submit();</script>"; // hide form if js on
		}
		else {
		  // Show an error message
		  if (empty($nextStep['content']))
		    $result['error'] = "Unexpected error.";
		  else
			  $result['error'] = $nextStep['content'];
		}

		return $result;
  }

  // Override this method in your app if you want to add parameters to the openid request
  // For example, adding fields to request like nickname or date of birth.
  protected function setOpenIDRequestParameters(sfPHPOpenID $openid_object) {
    /*
    // This is an example of code you can write in your app
    $openid_object->setRequestFields(array('nickname'));
    */
  }

	// This is the callback action used by the openID provider
	public function executeFinish(sfWebRequest $request)
	{
    $openid = new sfPHPOpenID();
    $openid->setIdentity($this->getRequestParameter('openid_identity'));

		$process_url = $this->getController()->genUrl('@openid_finishauth', true);
		$openid->setApprovedURL($process_url); // Script which handles a response from OpenID Server

		$trust_root = $this->getController()->genUrl('@homepage', true);
		$openid->SetTrustRoot($trust_root);

    $openid_validation_result = $openid->getAuthResult();

    if ($openid_validation_result['result'] == sfPHPOpenID::AUTH_SUCCESS) {
      $this->openIDCallback($openid_validation_result);
    }
    else {#print_r($openid_validation_result);echo __FILE__, ':', __LINE__; exit;
      if (!empty($openid_validation_result['message']))
        $this->getUser()->setFlash('openid_error', $openid_validation_result['message']);
      $this->redirect('@openid_error');
    }
	}

  // Override this method in your app. It is called when user has been authenticated.
	public function openIDCallback($openid_validation_result)
	{
	}
}
