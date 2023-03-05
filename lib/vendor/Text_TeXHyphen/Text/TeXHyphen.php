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
 * Main file of the Text_TeXHyphen package
 *
 * @package Text_TeXHyphen
 * @todo unit tests
 */

/**
 */
require_once 'PEAR/ErrorStack.php';

/**
 */
define('TEXT_TEXHYPHEN_ERROR', 0);
define('TEXT_TEXHYPHEN_ERROR_STR', 'Error');
define('TEXT_TEXHYPHEN_NOTICE', 1);
define('TEXT_TEXHYPHEN_NOTICE_STR', 'Notice');

/**
 * The class for the hyphenation of words with the TeX algorithm.
 *
 * @package Text_TeXHyphen
 * @author Stefan Ohrmann <bshell@gmx.net>
 * @version $Id$
 * @category Text
 */
class Text_TeXHyphen
{
    /**
     * Minimum characters before the first hyphen.
     *
     * @var integer
     *
     * @access private
     */
    var $_leftHyphenMin = 1;

    /**
     * Minimum characters after the last hyphen.
     *
     * @var integer
     *
     * @access private
     */
    var $_rightHyphenMin = 2;

    /**
     * Reference to a Text_TeXHyphen_PatternDB pattern database.
     *
     * @see Text_TeXHyphen_PatternDB
     *
     * @var Text_TeXHyphen_PatternDB
     *
     * @access private
     */
    var $_patternDB = null;

    /**
     * Reference to a Text_TeXHyphen_WordCache cache for hyphnated
     * words.
     *
     * @see Text_TeXHyphen_WordCache
     *
     * @var Text_TeXHyphen_WordCache
     *
     * @access private
     */
    var $_wordCache = null;

    /**
     * Reference to the error stack.
     *
     * @var PEAR_ErrorStack
     *
     * @access private
     */
    var $_errorStack;

    /**
     * Constructor of a Text_TeXHyphen object.
     *
     * At contruction of a Text_TeXHyphen object the error stack will
     * referencing to the 'Text_TeXHyphen' error stack.
     *
     * @access public
     */
    function Text_TeXHyphen()
    {
        $this->_errorStack = new PEAR_ErrorStack('Text_TeXHyphen');
    }

    /**
     * Factory for creating a Text_TeXHyphen object.
     *
     * As option you can pass a Text_TeXHyphen_WordCache object by
     * $options['wordcache'].
     *
     * @see Text_TeXHyphen_PatternDB
     * @see Text_TeXhyphen_WordCache
     * @see setPatternDB()
     * @see setWordCache()
     *
     * @param Text_TeXHyphen_PatternDB $patternDB Reference to a
     * Text_TeXHyphen_PatternDB object.
     * @param array $options Options for the Text_TeXHyphen object.
     *
     * @return Text_TeXHyphen|false Reference to a Text_TeXHyphen
     * object or false on error.
     *
     * @access public
     */
    static public function factory(&$patternDB, $options = array())
    {
        $errorStack = new PEAR_ErrorStack('Text_TeXHyphen');

        $hyphen = new Text_TeXHyphen();

        if (!$hyphen->setPatternDB($patternDB)) {
            $errorStack->push(
                TEXT_TEXHYPHEN_ERROR,
                TEXT_TEXHYPHEN_ERROR_STR,
                array('patternDB' => $patternDB),
                'Invalid pattern database!');
            return false;
        }

        if (isset($options['wordcache'])) {
            $wordCache =& $options['wordcache'];
            if (!$hyphen->setWordCache($wordCache)) {
                $errorStack->push(
                    TEXT_TEXHYPHEN_NOTICE,
                    TEXT_TEXHYPHEN_NOTICE_STR,
                    array('wordCache' => $wordCache),
                    'Invalid word cache!');
            }
        }

        return $hyphen;

    } // end of function factory

    /**
     * Sets a reference to a Text_TeXHyphen_PatternDB database.
     *
     * @see Text_TeXHyphen_PatternDB
     *
     * @param Text_TeXHyphen_PatternDB $patternDB Reference to a
     * object of type Text_TeXHyphen_PatternDB or a subclass of it.
     *
     * @return boolean true, if $patternDB is of valid type otherwise
     * false
     *
     * @access public
     */
    function setPatternDB(&$patternDB)
    {
        if ( ! ($patternDB instanceof Text_TeXHyphen_PatternDB) ) {
            return false;
        }

        $this->_patternDB =& $patternDB;
        return true;
    } // end of function setPatternDB

    /**
     * Sets a reference to a Text_TeXHyphen_WordCache cache.
     *
     * @see Text_TeXHyphen_WordCache
     *
     * @param Text_TeXHyphen_WordCache $wordCache Reference to a
     * object of type Text_TeXHyphen_WordCache or a subclass of it.
     *
     * @return boolean true, if $wordCache is of valid type otherwise
     * false.
     *
     * @access public
     */
    function setWordCache(&$wordCache)
    {
        if ( ! ($wordCache instanceof Text_TeXHyphen_WordCache) ) {
            return false;
        }

        $this->_wordCache =& $wordCache;
        return true;
    } // end of function setWordCache

    /**
     * Gets the syllables of a word.
     *
     * If no syllables ar found then also an array with the passed
     * word is returned.
     *
     * @param string $word Word of which the syllables should
     * calculated.
     *
     * @return array Array of string, if $word contains non word
     * charachters, the word will returned unchanged.
     *
     * @access public
     */
    function getSyllables($word)
    {
        $word = trim($word);

        /* can cause errors, because of language settings of the server
        if (0 != preg_match('![^\w]+!i', $word)) {
            return array($word);
        }
        */

        $wordLen = strlen($word);

        if ($wordLen <= ($this->_leftHyphenMin + $this->_rightHyphenMin) ) {
            return array($word);
        }

        if (!is_null($this->_wordCache)) {
            $cachedWord = $this->_wordCache->getSyllables($word);
            if (false !== $cachedWord) {
                return $cachedWord;
            }
        };

        $hyphenValues = $this->_getHyphenValues($word);
        $sylArr = array();
        $syl = '';
        for ($i = 0; $i < $wordLen; $i++) {
            if (($i >= $this->_leftHyphenMin) &&
                ($i <= ($wordLen - $this->_rightHyphenMin)) &&
                ($hyphenValues[$i] % 2 == 1) ) {
                $sylArr[] = $syl;
                $syl = '';
            };
            $syl .= $word[$i];
        };
        $sylArr[] = $syl;

        if (!is_null($this->_wordCache)) {
            $this->_wordCache->add($word, $sylArr);
        }

        return $sylArr;
    } // end of function getSyllables

    /**
     * Gets the desireabilty of a hyphen between the charcters.
     *
     * Parses the $word for patterns and sets desirability of a hyphen
     * between characters, which depends on the found pattern.
     *
     * @param string $word Word of which the hyphen values should
     * found.
     *
     * @return array Array of integers with the desireablity of a
     * hyphen.
     *
     * @access private
     */
    function _getHyphenValues($word) {
        $word = strtolower(".".$word.".");
        $wordLen = strlen($word);
        $values = array_fill(0, $wordLen + 1, 0);
        for ($i = 0; $i < $wordLen; $i++) {
            $keyStr = '';
            for ($j = 0; ($i + $j) < $wordLen; $j++ ) {
                $keyStr .= $word[$i+$j];
                if (false !== ($pattern = $this->_patternDB->getPattern($keyStr))) {
                    $hv = $pattern->getHyphenValues();
                    $keyLen = strlen($keyStr);
                    for ($k = 0; $k <= $keyLen; $k++) {
                        $values[$i+$k] = max($hv[$k], $values[$i+$k]);
                    };
                };
            };
        };
        array_shift($values);
        return $values;
    } // end of function _getHyphenValues

} // end of class Text_TeXHyphen
