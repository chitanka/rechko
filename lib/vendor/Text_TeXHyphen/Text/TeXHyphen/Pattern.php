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
 * Implementation of Text_TeXHyphen_Pattern
 *
 * @package Text_TeXHyphen
 */

/**
 * The pattern class for the TeX hyphenation algorithm.
 *
 * @author Stefan Ohrmann <bshell@gmx.net>
 * @version $Id$
 * @package Text_TeXHyphen
 */
class Text_TeXHyphen_Pattern
{
    /**
     * The pattern from the TeX hyphenation file.
     *
     * The pattern contains of charachters, digits between the
     * characters and optional a dot at the start or the end.
     *
     * @see setPattern()
     *
     * @var string TeX pattern string.
     *
     * @access private
     */
    var $_pattern = '';

    /**
     * The key identifies the pattern.
     *
     * The key is a unique identifier, which contains only of
     * characters and optional a dot at the start or the end. It will
     * created from the TeX pattern.
     *
     * @see $_pattern
     * @see createKey()
     *
     * @var string Key by which the pattern is identified.
     *
     * @access private
     */
    var $_key = '';

    /**
     * These are the values for the desireability of a hyphen.
     *
     * Each array entry values the desireability of a hyphen between
     * the characters of the pattern. The higher the value the
     * stronger the desireability of a hyphen. A odd value denotes a
     * possible hyphen, whereas an even value denotes an impossible
     * hyphen.
     * The array is created from the pattern. If there is no number
     * between two characters, 0 is included.
     *
     * @see $_pattern
     * @see createHyphenValues()
     *
     * @var array Array of integers.
     *
     * @access private
     */
    var $_hyphenValues = array();

    /**
     * Factory for creating a Text_TeXHyphen_Pattern object from a
     * TeX pattern string.
     *
     * The factory initalizes a new Text_TeXHyphen_Pattern object,
     * creates the key and the hyphen values. If the pattern string
     * didn't meet the criterias of isValid(), false will returned.
     * This also occurs, if the creation of the key or the hyphen
     * values return an error.
     *
     * @see isValid()
     * @see setPattern()
     * @see createKey()
     * @see createHyphenValues()
     *
     * @param string $patternStr TeX pattern string.
     *
     * @return Text_TeXHyphen_Pattern|false Reference to a
     * Text_TeXHyphen_Pattern object or false on error.
     *
     * @access public
     */
    static public function factory($patternStr)
    {
        $pattern = new Text_TeXHyphen_Pattern();

        if (!$pattern->setPattern($patternStr)) {
            return false;
        }

        return $pattern;
    } // end of function factory


    /**
     * Validates a pattern string against some special criterias.
     *
     * The pattern string have to meet following criterias:
     * - not empty
     * - not only a combination of whitepace charaters, digits or dots
     * - no whitespace character at all
     * - no dots inside the string
     *
     * All other validation for a correct pattern string have to take
     * place outside the class.
     * This decision was made, because different languages could have
     * different characters allowed in pattern strings.
     *
     * @param string $patternStr TeX pattern string.
     *
     * @return boolean true, if valid otherwise false
     *
     * @access public
     */
    function isValid($patternStr)
    {
        $patternStr = preg_replace('!\d!i','', $patternStr);
        $patternStr = trim($patternStr);

        if (0 === strlen($patternStr)) {
            return false;
        }

        // Looks for whitespace characters in trimmed $patternStr.
        if (0 !== preg_match('!\s!i', $patternStr)) {
            return false;
        }

        // Checks, if $patternStr contains only of dots.
        if (0 !== preg_match('!^\.+$!i', $patternStr)) {
            return false;
        }

        // Checks, if in $patternStr exists dots, but at the start or
        // end. The pattern will only return 0, if a dot in in the
        // middle.
        if (0 === preg_match('!^\.?[^\.]*\.?$!i', $patternStr)) {
            return false;
        }

        return true;
    } // end of function isValid

    /**
     * Sets the TeX pattern string.
     *
     * Whitespace charaters at the start and end will trimed. The key
     * and hyphen values are created automatic. False will returned, if
     * the pattern string is invalid or the key and hyphen values
     * creation fail, otherwise true.
     *
     * @param string $patternStr TeX pattern string.
     *
     * @return boolean true, if pattern string is valid, the key and
     * the hyphen values could created otherwise false.
     *
     * @access public
     */
    function setPattern($patternStr)
    {
        $patternStr = trim($patternStr);

        if (!$this->isValid($patternStr)) {
            return false;
        }
        $this->_pattern = $patternStr;

        $key = self::createKey($patternStr);
        if (false === $key) {
            return false;
        }
        $this->_key = $key;

        $hv = $this->createHyphenValues($patternStr);
        if (false === $hv) {
            return false;
        }
        $this->_hyphenValues = $hv;

        return true;
    } // end of function setPattern

    /**
     * Gets the TeX pattern string.
     *
     * @return string|false the TeX pattern string or false, if the
     * pattern string contains only of whitespace characters.
     *
     * @access public
     */
    function getPattern()
    {
        if (0 == strlen(trim($this->_pattern))) {
            return false;
        }
        return $this->_pattern;
    } // end of function getPattern

    /**
     * Creates the key from a TeX pattern string
     *
     * The key contains only of the characters and dots of the TeX
     * pattern string. False will return, if the resulting key
     * contains only of whitespace characters.
     *
     * @param string $patternStr TeX pattern string.
     *
     * @return string|false the key of the TeX pattern string or
     * false, if the created key contains only of whitespace
     * characters.
     *
     * @access public
     */
    static public function createKey($patternStr)
    {
        $patternStr = trim($patternStr);

        $key = preg_replace('!\d!i','', $patternStr);
        $key = trim($key);

        if (0 == strlen($key)) {
            return false;
        }

        return $key;
    } // end of function createKey

    /**
     * Gets the key of the pattern.
     *
     * If the key contains only of whitspace characters
     * false will returned.
     *
     * @return string|false the key by which the pattern can be
     * identified or false, if the key contains only of whitespace
     * characters.
     *
     * @access public
     */
    function getKey()
    {
        if (0 == strlen(trim($this->_key))) {
            return false;
        }
        return $this->_key;
    } // end of function getKey

    /**
     * Creates the hyphen values from a TeX pattern string.
     *
     * The hyphen values are an array of intergers, which values the
     * desireability of a hyphen between two characters.
     *
     * @param string $patternStr TeX pattern string
     *
     * @return array|false Array of integer or false, if the TeX pattern
     * string contains only of whitespace characters.
     *
     * @access public
     */
    function createHyphenValues($patternStr)
    {
        $patternStr = trim($patternStr);

        if (0 == strlen($patternStr)) {
            return false;
        }

        $cnt = strlen($patternStr);
        $hv = array_fill(0, $cnt + 1, 0);
        $j = 0;
        for ($i = 0; $i < $cnt; $i++) {
            $c = $patternStr[$i];
            if (is_numeric($c)) {
                $hv[$j] *= 10;
                $hv[$j] += intval($c);
            } else {
                $j++;
            }
        };
        return $hv;
    } // end of function createHyphenValues

    /**
     * Gets the hyphen values of the pattern.
     *
     * @return array|false Array of integers or false, if the hyphen
     * values is empty or not an array.
     *
     * @access public
    */
    function getHyphenValues()
    {
        if (!is_array($this->_hyphenValues) || empty($this->_hyphenValues)) {
            return false;
        }
        return $this->_hyphenValues;
    }// end of function getHyphenValues

    /**
     * Gets the hyphen value at a passed index.
     *
     * False will return, if the hyphen value isn't set or the value
     * isn't an integer.
     *
     * @param integer $index Index of the value.
     *
     * @return integer|false the value at the index in the hyphen
     * values or false, if the hyphen values are invalid or the index
     * isn't available.
     *
     * @access public
     */
    function getHyphenValue($index)
    {
        if (!isset($this->_hyphenValues[$index]) || (!is_int($this->_hyphenValues[$index]))) {
            return false;
        }
        return $this->_hyphenValues[$index];
    } // end of function getHyphenValue

} // end of class Text_TeXHyphen_Pattern
