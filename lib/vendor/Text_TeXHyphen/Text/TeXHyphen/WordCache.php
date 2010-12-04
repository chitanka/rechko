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
 * Implementation of the Text_TeXHyphen_WordCache
 * @package Text_TeXHyphen
 */

/**
 */
require_once 'PEAR/ErrorStack.php';

/**
 */
define('TEXT_TEXHYPHEN_WORDCACHE_ERROR', 4);
define('TEXT_TEXHYPHEN_WORDCACHE_ERROR_STR', 'Error');
define('TEXT_TEXHYPHEN_WORDCACHE_NOTICE', 5);
define('TEXT_TEXHYPHEN_WORDCACHE_NOTICE_STR', 'Notice');

/**
 * The abstract of the word cache class for the TeX hyphenation
 * algorithm.
 *
 * @author Stefan Ohrmann <bshell@gmx.net>
 * @version $Id$
 * @package Text_TeXHyphen
 */
class Text_TeXHyphen_WordCache
{
    /**
     * The 'Text_TeXHyphen' error stack.
     *
     * @var PEAR_ErrorStack Reference to a PEAR_ErrorStack object.
     *
     * @access private
     */
    var $_errorStack;

    /**
     * Constructor of a Text_TeXHyphen_WordCache object.
     *
     * At contruction of a Text_TeXHyphen_WordCache object the
     * error stack will referenced to the 'Text_TeXHyphen' error
     * stack.
     *
     * @access public
     */
    function Text_TeXHyphen_WordCache()
    {
        $this->_errorStack = new PEAR_ErrorStack('Text_TeXHyphen');
    }

    /**
     * Factory for creating a word.
     *
     * @param string $type Name of the word cache implementation.
     * @param array $options Options for word cache implementation.
     *
     * @return Text_TeXHyphen_WordCache|false Reference to an object
     * of type Text_TeXHyphen_WordCache or a subclass of it, if successful or
     * false on error.
     *
     * @access public
     */
    static public function factory($type, $options = array())
    {
        $errorStack = new PEAR_ErrorStack('Text_TeXHyphen');

        $type = strtolower($type);

        require_once dirname(__FILE__) . '/WordCache/'.$type.'.php';

        $classname = 'Text_TeXHyphen_WordCache_'.$type;

        if (!class_exists($classname)) {
            $errorStack->push(
                TEXT_TEXHYPHEN_WORDCACHE_ERROR,
                TEXT_TEXHYPHEN_WORDCACHE_ERROR_STR,
                array('classname' => $classname),
                'Unable to include class file!');
            return false;
        }

        $obj = call_user_func_array(array($classname,'factory'), array($type, $options));

        return $obj;
    } // end of function factory

    /**
     * Gets the syllables of a word, if found in cache.
     *
     * @param string $word Word of which the syllables should got.
     *
     * @return array|false Array of string or false, if $word isn't
     * found.
     *
     * @access public
     */
    function getSyllables($word)
    {
        return false;
    } // end of function lookUp

    /**
     * Adds a word and its syllables to the cache.
     *
     * @param string $word Word, which syllables should stored.
     * @param array $syls Array of strings, which contains of the
     * syllables of the $word.
     *
     * @return boolean true, if the $word could added to the cache
     * otherwise false.
     */
    function add($word, $syls)
    {
        return true;
    } // end of function add

} // end of class Text_TeXHyphen_PatternDB
