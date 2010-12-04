<?php
//
// +------------------------------------------------------------------------+
// | PEAR :: Text :: TeXHyphen                                              |
// +------------------------------------------------------------------------+
// | Copyright (c) 2004 Stefan Ohrmann <bshell@gmx.net>.                    |
// +------------------------------------------------------------------------+
// | This source file is subject to version 3.00 of the PHP License,        |
// | that is available at http://www.php.net/license/3_0.txt.               |
// | If you did not receive a copy of the PHP license and are unable to     |
// | obtain it through the world-wide-web, please send a note to            |
// | license@php.net so we can mail you a copy immediately.                 |
// +------------------------------------------------------------------------+
//
// $Id$
//

/**
 * Implementation of Text_TeXHyphen_PatternValidator
 *
 * @package Text_TeXHyphen
 *
 * @todo Implentation of the Text_TeX_PatternValidator
 */

/**
 * The pattern validation class for the TeX pattern strings.
 *
 * @author Stefan Ohrmann <bshell@gmx.net>
 * @version $Id$
 * @package Text_TeXHyphen
 */
class Text_TeXHyphen_PatternValidator
{
    /*
     * 
     * This contains the mode and options for a pattern validation
     *
     * mode: 'none', no validation a all, the function call returns always true
     *       'regEx', the pattern will matched via preg_match against the regular expression in 'option'
     *       'object', the pattern will validatet via the object in 'option' via a call of $object->validate($pattern)
     *
     *
     * option: 
     * The regular expression that match a valid pattern
     *
     * Dots are only at the begin and the end of a pattern allowed.
     * After/Before a dot can only be a character.
     * Digits and characters are not allowed to be alone.
     *
     *
     * var $_patternValidation = 
     *      array('mode' => 'regex',
     *            'option' => '!^(\.[a-zäüöß])?([0-9]+[a-zäüöß]+[0-9a-zäüöß]*|[a-zäüöß]+[0-9]+[0-9a-zäüöß]*)([a-zäüöß]\.)?$!i');
     */
     
     /**
      * Validates an TeX pattern string.
      *
      * @param string $patternStr TeX pattern string
      *
      * @return boolean true, if valid, otherwise false
      */
     function validate($patternStr)
     {
         return true;
     }
}
?>