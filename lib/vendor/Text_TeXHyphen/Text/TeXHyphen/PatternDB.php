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
 * Implementation of the Text_TeXHyphen_PatternDB
 * @package Text_TeXHyphen
 */

/**
 *
 */
require_once 'PEAR/ErrorStack.php';

/**
 *
 */
define('TEXT_TEXHYPHEN_PATTERNDB_ERROR', 2);
define('TEXT_TEXHYPHEN_PATTERNDB_ERROR_STR', 'Error');
define('TEXT_TEXHYPHEN_PATTERNDB_NOTICE', 3);
define('TEXT_TEXHYPHEN_PATTERNDB_NOTICE_STR', 'Notice');

/**
 * The abstract of the pattern database class for the TeX hyphenation
 * algorithm.
 *
 * @author Stefan Ohrmann <bshell@gmx.net>
 * @version $Id$
 * @package Text_TeXHyphen
 */
class Text_TeXHyphen_PatternDB
{
    /**
     * The validator which validates the TeX pattern strings.
     *
     * @see Text_TeXHyphen_PatternValidator
     *
     * @var Text_TeXHyphen_PatternValidator Reference to a
     * Text_TeXHyphen_PatternValidator object.
     *
     * @access private
     */
    var $_validator = null;

    /**
     * The 'Text_TeXHyphen' error stack.
     *
     * @var PEAR_ErrorStack Reference to a PEAR_ErrorStack object.
     *
     * @access private
     */
    var $_errorStack;

    /**
     * Constructor of a Text_TeXHyphen_PatternDB object.
     *
     * At contruction of a Text_TeXHyphen_PatternDB object the
     * error stack will referenced to the 'Text_TeXHyphen' error
     * stack.
     *
     * @access public
     */
    function Text_TeXHyphen_PatternDB()
    {
        $this->_errorStack = new PEAR_ErrorStack('Text_TeXHyphen');
    }

    /**
     * Factory for creating a pattern database.
     *
     * @param string $type Name of the pattern database implementation.
     * @param array $options Options for pattern database implementation.
     *
     * @return Text_TeXHyphen_PatternDB|false Reference to an object
     * of type Text_TeXHyphen_PatternDB or a subclass of it, if successful or
     * false on error.
     *
     * @access public
     */
    static public function factory($type, $options = array())
    {
        $errorStack = new PEAR_ErrorStack('Text_TeXHyphen');

        $type = strtolower($type);

        require_once dirname(__FILE__) . '/PatternDB/'.$type.'.php';

        $classname = 'Text_TeXHyphen_PatternDB_'.$type;

        if (!class_exists($classname)) {
            $errorStack->push(
                TEXT_TEXHYPHEN_PATTERNDB_ERROR,
                TEXT_TEXHYPHEN_PATTERNDB_ERROR_STR,
                array('classname' => $classname),
                'Unable to include class file!');
            return false;
        }

        $obj = call_user_func_array(array($classname,'factory'), array($type, $options));

        return $obj;
    }

    /**
     * Gets the Text_TeXHyphen_Pattern object specified by the $key,
     * if it exists in the pattern database.
     *
     * @see Text_TeXHyphen_Pattern
     *
     * @param string $key Key by which the pattern should be
     * identified.
     *
     * @return Text_TeXHyphen_Pattern|false Reference to a
     * Text_TeXHyphen_Pattern object if successful or false
     * if the pattern isn't found.
     *
     * @access public
     */
    function getPattern($key)
    {
        return false;
    } // end of function getPattern

} // end of class Text_TeXHyphen_PatternDB
