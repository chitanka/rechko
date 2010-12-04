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
 * This validator will check if a given string is a valid OpenID
 *
 */

class sfPHPOpenIdValidator extends sfValidatorBase
{

  public function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
    $this->setMessage('required', 'Your OpenID URL is missing.');
    $this->setMessage('invalid', 'Your OpenID is incorrect.');
  }
  
  public function doClean($value)
  {
    $re = "
      /^                                                      # Start at the beginning of the text
      ((?:https?):\/\/)?                                      # Look for http, or https schemes (or no scheme)
      (?:                                                     # Userinfo (optional) which is typically
        (?:(?:[\w\.\-\+!$&'\(\)*\+,;=]|%[0-9a-f]{2})+:)*      # a username or a username and password
        (?:[\w\.\-\+%!$&'\(\)*\+,;=]|%[0-9a-f]{2})+@          # combination
      )?
      (?:
        (?:[a-z0-9\-\.]|%[0-9a-f]{2})+                        # A domain name or a IPv4 address
        |(?:\[(?:[0-9a-f]{0,4}:)*(?:[0-9a-f]{0,4})\])         # or a well formed IPv6 address
      )
      (?::[0-9]+)?                                            # Server port number (optional)
      (?:[\/|\?]
        (?:[\w#!:\.\?\+=&@$'~*,;\/\(\)\[\]\-]|%[0-9a-f]{2})   # The path and query (optional)
      *)?
    $/xi";
    
    if (empty($value) || ($value == 'http://') || ($value == 'https://')) {
      throw new sfValidatorError($this, 'required');
    }
    
    if (!preg_match($re, $value)) {
      throw new sfValidatorError($this, 'invalid');
    }

    return $value;
  }
}
