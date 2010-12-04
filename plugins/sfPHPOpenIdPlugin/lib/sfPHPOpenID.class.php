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
 * This class is a wrapper around PHP OpenID library.
 */

$libIncludePath = sfConfig::get('app_sf_phpopenid_plugin_lib_path');
if (empty($libIncludePath))
  $libIncludePath = sfConfig::get('sf_root_dir') . '/lib/php-openid';

set_include_path(get_include_path() . PATH_SEPARATOR . $libIncludePath);
require_once "Auth/OpenID/Consumer.php";
require_once "Auth/OpenID/FileStore.php";
require_once "Auth/OpenID/SReg.php";
require_once "Auth/OpenID/PAPE.php";
require_once "Auth/OpenID/AX.php";

// borislav
#error_reporting(E_ERROR | E_WARNING | E_PARSE); // php-openid generate a lot of harmless warnings with php5

class sfPHPOpenID {
  const AUTH_SUCCESS        = 0;
  const AUTH_CANCEL         = 1;
  const AUTH_FAILURE        = 2;
  const AUTH_SETUP_NEEDED   = 3;

  private $openid_url_identity;
  private $trust_root;
  private $approved_url;
  private $PAPE_policies = array();
  private $request_fields_sreg = array('fullname', 'email');
  private $request_fields_AX = array('fullname' => 'http://axschema.org/namePerson',
                                     'firstname' => 'http://axschema.org/namePerson/first',
                                     'lastname' => 'http://axschema.org/namePerson/last',
                                     'email' =>'http://axschema.org/contact/email');
  private $required_AX_fields = array('fullname', 'email', 'firstname', 'lastname'); // List of required fields from $request_fields_AX. Default (= not specified) is not required.
  private $count_AX_fields = array(); // The number of values requested for the corresponding AX field. Default (= not specified) is unlimited.

  private $available_sreg_values =  array('dob',
                                          'gender',
                                          'postcode',
                                          'country',
                                          'language',
                                          'timezone');

  private $default_sreg_values =    array('nickname',
                                          'email',
                                          'fullname');

  private $mapping_sreg_ax     =    array('nickname' => 'http://axschema.org/namePerson/friendly',
                                          'email' => 'http://axschema.org/contact/email',
                                          'fullname' => 'http://axschema.org/namePerson',
                                          'firstname' => 'http://axschema.org/namePerson/first',
                                          'lastname' => 'http://axschema.org/namePerson/last',
                                          'dob' => 'http://axschema.org/birthDate',
                                          'gender' => 'http://axschema.org/person/gender',
                                          'postcode' => 'http://axschema.org/contact/postalCode/home',
                                          'country' => 'http://axschema.org/contact/country/home',
                                          'language' => 'http://axschema.org/pref/language',
                                          'timezone' => 'http://axschema.org/pref/timezone');

  /**
   * getRedirectURL
   * Prepare an http request to send to the openid provider.
   *
   * @returns An array: 'type' => 'url|form|error', 'content' => 'the Url or the form content or error message'
   */
  public function getRedirectURL($immediate = false, $submitLabel = '')
  {
    if (empty($submitLabel))
      $submitLabel = 'Continue';

    $consumer = $this->getConsumer();

    // Begin the OpenID authentication process.
    $auth_request = $consumer->begin($this->getIdentity());

    // No auth request means we can't begin OpenID.
    if (!$auth_request) {
        return array('type' => 'error', 'content' => "Authentication error: not a valid OpenID (".$this->getIdentity().").");
    }

    $sreg_request = Auth_OpenID_SRegRequest::build(
                                     // Required
                                     array('nickname'),
                                     // Optional
                                     $this->getRequestFieldsSREG());

    if ($sreg_request) {
        $auth_request->addExtension($sreg_request);
    }

    // PAPE support (see http://openid.net/specs/openid-provider-authentication-policy-extension-1_0.html)
    $pape_request = new Auth_OpenID_PAPE_Request($this->PAPE_policies);
    if ($pape_request) {
        $auth_request->addExtension($pape_request);
    }

    // Add Attribute Exchange request information (see http://openid.net/specs/openid-attribute-exchange-1_0.html).
    $ax_request = new Auth_OpenID_AX_FetchRequest();
    if ($ax_request) {
      foreach ($this->request_fields_AX as $alias => $url) {
        $ax_request->add(new Auth_OpenID_AX_AttrInfo($url, $this->getCountForAXField($alias), $this->isRequiredAXField($alias), $alias));
      }
      $auth_request->addExtension($ax_request);
    }

    // Redirect the user to the OpenID server for authentication.
    // Store the token for this authentication so we can verify the
    // response.

    // For OpenID 1, send a redirect.  For OpenID 2, use a Javascript
    // form to send a POST request to the server.
    if ($auth_request->shouldSendRedirect()) {
        $redirect_url = $auth_request->redirectURL($this->getTrustRoot(),
                                                   $this->getApprovedURL(),
                                                   $immediate);

        // If the redirect URL can't be built, display an error
        // message.
        if (Auth_OpenID::isFailure($redirect_url)) {
            return array('type' => 'error', 'content' => "Could not redirect to server: " . $redirect_url->message);
        } else {
            // Send redirect.
            return array('type' => 'url', 'content' => $redirect_url);
        }
    } else {
        // Generate form markup and render it.
        $form_id = 'openid_message';

        $form_html = $this->formMarkupWithLabel($auth_request, $this->getTrustRoot(), $this->getApprovedURL(),
                                               $immediate, array('id' => $form_id), $submitLabel);

        // Display an error if the form markup couldn't be generated;
        // otherwise, render the HTML.
        if (Auth_OpenID::isFailure($form_html)) {
            return array('type' => 'error', 'content' => "Could not redirect to server: " . $form_html->message);
        } else {
            return array('type' => 'form', 'content' => $form_html);
        }
    }
  }

  // This method has been adapted from PHP OpenID lib code to allow the use of submitLabel
  private function formMarkupWithLabel($auth_request, $realm, $return_to=null, $immediate=false,
                                       $form_tag_attrs=null, $submitLabel)
  {
      $message = $auth_request->getMessage($realm, $return_to, $immediate);

      if (Auth_OpenID::isFailure($message))
          return $message;

      return $message->toFormMarkup($auth_request->endpoint->server_url,
                                    $form_tag_attrs, $submitLabel);
  }

  /**
   * setIdentity
   * Sets the url given by the user as his identity
   *
   * @param identity The user's identity (example: http://misterx.myopenid.com)
   */
  public function setIdentity($identity)
  {   // Set Identity URL
    if (strpos($identity, 'http://') === false && strpos($identity, 'https://') === false) {
      // Gmail is an exception: user can give an email adress and we'll discover the correct url for him
      // This kind of behavior might be more widely used in the future. Or not.
      if (strrpos($identity, '@gmail.com') == strlen($identity) - strlen('@gmail.com'))
        $identity = 'http://www.google.com/accounts/o8/id';
      else
        $identity = 'http://'.$identity;
    }
    // if this is a server we want a trailing slash
    // therefore if there isn't a slash somewhere in the url after
    // http:// add one
    if (preg_match('|^http[s]?://[^/]+$|', $identity))
    {
      $identity .= '/';
    }
    $this->openid_url_identity = $identity;
  }

  /**
   * getIdentity
   * Returns the url given by the user as his identity
   *
   * @returns The user's identity (example: http://misterx.myopenid.com)
   */
  public function getIdentity()
  {
    return $this->openid_url_identity;
  }

  /**
   * setApprovedURL
   * Set the url where the user will get back after authentification
   *
   * @param The url
   */
  public function setApprovedURL($url)
  {
    $this->approved_url = $url;
  }

  /**
   * getApprovedURL
   * Returns the url where the user will get back after authentification
   *
   * @returns The url
   */
  public function getApprovedURL()
  {
    return $this->approved_url;
  }

  /**
   * setTrustRoot
   * Set the root of the website where the user wants to login
   *
   * @param The url of the root
   */
  public function setTrustRoot($url)
  {
    $this->trust_root = $url;
  }

  /**
   * getTrustRoot
   * Returns the root of the website where the user wants to login
   *
   * @returns The url of the root
   */
  public function getTrustRoot()
  {
    return $this->trust_root;
  }

  /**
   * setPAPEPolicies
   * Set the PAPE policy URIs (adding to the ones already set)
   *
   * @param $uris An array of PAPE policy URIs
   */
  public function setPAPEPolicies($uris)
  {
    if (is_array($uris))
      $this->PAPE_policies = array_merge($this->PAPE_policies, $uris);
    else
      $this->PAPE_policies[] = $uris;
  }

  /**
   * getPAPEPolicies
   * Returns the currently active PAPE policy URIs
   *
   * @returns An array of currently active PAPE policy URIs
   */
  public function getPAPEPolicies()
  {
    return $this->PAPE_policies;
  }

  /**
   * getAvailablePAPEPolicies
   * Returns the list of available PAPE policies
   *
   * @returns An array of available PAPE policy URIs
   */
  public function getAvailablePAPEPolicies()
  {
    $pape_policy_uris = array(
			  PAPE_AUTH_MULTI_FACTOR_PHYSICAL,
			  PAPE_AUTH_MULTI_FACTOR,
			  PAPE_AUTH_PHISHING_RESISTANT
			  );
    return $pape_policy_uris;
  }

  /**
   * setRequestFields
   * Sets the fields that should be retrieved from the user openid account.
   * There's no guarantee that the user allow the publication of these info!
   * Fields beginning with 'http://' and with a non-numeric key are considered as AX types
   * (for example: array(..., 'companyName' => 'http://axschema.org/company/name', ...))
   * (see http://openid.net/specs/openid-attribute-exchange-1_0.html).
   *
   * @param fields An array of fields to retrieve
   */
  public function setRequestFields($fields)
  {
    foreach ($fields as $id => $field) {
      if (!empty($field)) {
        if ( in_array($field, $this->available_sreg_values) && !in_array($field, $this->request_fields_sreg)) {
          $this->request_fields_sreg[] = $field;
          $this->request_fields_AX[$field] = $mapping_sreg_ax[$field];
        }
        else if (!is_numeric($id) && (strpos($field, 'http://') === 0 || strpos($field, 'https://') === 0) && !array_key_exists($id, $this->request_fields_AX) && !in_array($id, $this->request_fields_SREG)) {
          // This is and AX field with no SREG corresponding field
          $this->request_fields_AX[$id] = $field;
        }
      }
    }
  }

  /**
   * getRequestFieldsSREG
   * Gets the SREG fields that should be retrieved from the user openid account
   *
   * @returns fields An array of fields to retrieve
   */
  public function getRequestFieldsSREG()
  {
    return $this->request_fields_sreg;
  }

  /**
   * getRequestFieldsAX
   * Gets the AX fields that should be retrieved from the user openid account
   *
   * @returns fields An array of fields to retrieve
   */
  public function getRequestFieldsAX()
  {
    return $this->request_fields_AX;
  }

 /**
  * setRequiredAXFields
  * Set the given AX fields as required.
  *
  * @param required An array of AX fields aliases.
  */
  public function setRequiredAXFields($required) {
    $this->required_AX_fields = array_merge($this->required_AX_fields, $required);
  }

 /**
  * getRequiredAXFields
  * Get the required AX fields.
  *
  * @returns An array of required AX fields aliases.
  */
  public function getRequiredAXFields() {
    return $this->required_AX_fields;
  }

 /**
  * isRequiredAXField
  * Returns wether the given AX field alias is required or not.
  *
  * @param $alias An AX field alias
  * @returns Returns wether the given AX field alias is required or not.
  */
  public function isRequiredAXField($alias) {
    return in_array($alias, $this->required_AX_fields);
  }

 /**
  * setCountAXFields
  * Set the number of values to ask for the given AX fields.
  *
  * @param count An array of AX fields aliases (key) with the corresponding count (value).
  */
  public function setCountAXFields($count) {
    $this->count_AX_fields = array_merge($this->count_AX_fields, $count);
  }

 /**
  * getCountAXFields
  * Get the number of values to ask for each AX field (If not specified, count is unlimited).
  *
  * @returns An array of AX fields aliases (key) with the corresponding count (value).
  */
  public function getCountAXFields() {
    return $this->count_AX_fields;
  }

 /**
  * getCountForAXField
  * Get the number of values to ask for the given AX field alias.
  *
  * @param alias An AX field alias
  * @returns An array of AX fields aliases (key) with the corresponding count (value).
  */
  public function getCountForAXField($alias) {
    if (array_key_exists($alias, $this->count_AX_fields))
      return $this->count_AX_fields[$alias];

    return Auth_OpenID_AX_UNLIMITED_VALUES;
  }

 /**
  * getAuthResult
  * Returns the result of the authentification and the data retrieved from the user profile.
  *
  * @returns An array containing result and user data (in case of success):
  *  {'result' => 'result code',
  *   'message' => 'an optional message',
  *   'identity' => 'the user's identity (http://misterx.myopenid.com)',
  *   'userData' => 'array of user fields values ('fullname' => array('the fullname', 'another fullname'), 'email' => array('the email'), ...)'}
  *   'PAPEResp' => 'a Auth_OpenID_PAPE_Response object (null if the provider didn't send a PAPE response)'
  */
  public function getAuthResult()
  {
    $res = array();
    $res['result'] = sfPHPOpenID::AUTH_FAILURE;
    $res['message'] = '';
    $res['identity'] = '';
    $res['userData'] = array();
    $res['PAPEResp'] = '';

    $consumer = $this->getConsumer();

    // Complete the authentication process using the server's
    // response.
    $return_to = $this->getApprovedURL();
    $response = $consumer->complete($return_to);

    // Check the response status.
    if ($response->status == Auth_OpenID_CANCEL)
    {
        // This means the authentication was cancelled.
        $res['message'] = 'Verification cancelled.';
        $res['result'] = sfPHPOpenID::AUTH_CANCEL;
    }
    else if ($response->status == Auth_OpenID_FAILURE)
    {
        // Authentication failed; display the error message.
        $res['message'] = $response->message;
        $res['result'] = sfPHPOpenID::AUTH_FAILURE;
    }
    else if ($response->status == Auth_OpenID_SETUP_NEEDED)
    {
      $res['result'] = sfPHPOpenID::AUTH_SETUP_NEEDED;
    }
    else if ($response->status == Auth_OpenID_SUCCESS)
    {
        // This means the authentication succeeded; extract the
        // identity URL and Simple Registration data (if it was
        // returned).
        $openid = $response->getDisplayIdentifier();
        $res['result'] = sfPHPOpenID::AUTH_SUCCESS;
        $res['identity'] = htmlentities($openid);

        // Get SREG data
        $sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
        $sregData = $sreg_resp->contents();
        foreach ($sregData as $field => $value) {
          $res['userData'][$field] = array($value);
        }

        // Get AX data (use AX instead of SREG data if both are returned by the provider (or no SREG data))
        $ax_resp = new Auth_OpenID_AX_FetchResponse();
        $ax_resp = $ax_resp->fromSuccessResponse($response);
        if ($ax_resp) {
          foreach ($this->request_fields_AX as $alias => $url) {
            $get_ax = $ax_resp->get($url);
            if ( (! $get_ax instanceof Auth_OpenID_AX_Error) && (count($get_ax) > 0) )
              if (empty($res['userData'][$alias]))
                $res['userData'][$alias] = $get_ax;
              else
                $res['userData'][$alias] = array_filter(array_merge($res['userData'][$alias], $get_ax));
          }
        }

        $res['PAPEResp'] = Auth_OpenID_PAPE_Response::fromSuccessResponse($response);
    }

    return $res;
  }

  private function getStore() {
      /**
       * This is where the app will store its OpenID information.
       * You should change this path if you want the example store to be
       * created elsewhere.
       */
       // borislav
      $store_path = sys_get_temp_dir() . '/symfony_openid_filestore';

      if (!file_exists($store_path) &&
          !mkdir($store_path)) {
          print "OpenID: Could not create the FileStore directory '$store_path'. ".
              " Please check the effective permissions.";
          exit(0);
      }

      return new Auth_OpenID_FileStore($store_path);
  }

  private function getConsumer() {
      /**
       * Create a consumer object using the store object created
       * earlier.
       */
      $store = $this->getStore();
      $consumer = new Auth_OpenID_Consumer($store);
      return $consumer;
  }
}
