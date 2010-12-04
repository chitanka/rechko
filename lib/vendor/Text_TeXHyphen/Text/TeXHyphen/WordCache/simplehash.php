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
 * Implementation of the Text_TeXHyphen_WordCache_SimpleHash
 * @package Text_TeXHyphen
 * @todo unit test
 */

/**
 */
require_once 'PEAR/ErrorStack.php';
require_once dirname(__FILE__) . '/../WordCache.php';

/**
 * A simple hash class as word cache for the TeX hyphenation
 * algorithm.
 *
 * @author Stefan Ohrmann <bshell@gmx.net>
 * @version $Id$
 * @package Text_TeXHyphen
 */
class Text_TeXHyphen_WordCache_SimpleHash extends Text_TeXHyphen_WordCache
{
    /**
     * The hash contains the syllables.
     *
     * The key is the word of which the syllables are stored
     *
     * @var array Array of array of strings.
     *
     * @access private
     */
    var $_hash = array();

    /**
     * Factory for creating a word.
     *
     * @param string $type Name of the word cache implementation, must
     * 'simplehash'.
     * @param array $options Options for the word cache.
     *
     * @return Text_TeXHyphen_WordCache_SimpleHash|false Reference to
     * a object of type Text_TeXHyphen_WordCache_SimpleHash, a
     * subclass of Text_TeXHyphen_WordCache, or false on error.
     *
     * @access public
     */
    static public function factory($type, $options = array())
    {
        $errorStack = new PEAR_ErrorStack('Text_TeXHyphen');

        $type = strtolower($type);
        if (0 !== strcasecmp($type, 'simplehash')) {
            $errorStack->push(
                TEXT_TEXHYPHEN_WORDCACHE_ERROR,
                TEXT_TEXHYPHEN_WORDCACHE_ERROR_STR,
                array('type' => $type),
                'Invalid type was set!');
            return false;
        }

        $wc = new Text_TeXHyphen_WordCache_SimpleHash;

        return $wc;
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
        $key = strtolower($word);
        if (!isset($this->_hash[$key])) {
            return false;
        }

        $syls = $this->_hash[$key];
        if (0 !== strncmp($word, $syls[0], 1)) {
            $syls[0] = ucfirst($syls[0]);
        }

        return $syls;
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
        $key = strtolower($word);
        if (!isset($this->_hash[$key])) {
            $syls[0] = strtolower($syls[0]);
            $this->_hash[$word] = $syls;
        }
        return true;
    } // end of function add

    /**
     * Serializes the current state of the hash and returns the data.
     *
     * Takes the current hash and passes to serialize(). The returned
     * string, will compressed by gzcompress(), if $compression is
     * true.
     *
     * @param boolean $compression Decides, if the serialized hash is
     * compressed.
     *
     * @return string|false the (compressed) serialized hash data or
     * false on error.
     *
     * @access public
     */
    function serialize($compression = true)
    {
         $data = serialize($this->_hash);

         if ($compression) {
             $data = gzcompress($data);
         }

        if (false === $data) {
            $this->_errorStack->push(TEXT_TEXHYPHEN_WORDCACHE_ERROR,
                                     TEXT_TEXHYPHEN_WORDCACHE_ERROR_STR,
                                     array(),
                                     'Couldn\'t compress serialized the hash data');
            return false;
        }

        return $data;
    } // end of function serialize

    /**
     * Unserializes the hash from the data.
     *
     * Takes the $data and uncompresses the serialized hash, if
     * $compression is true. The serialized hash will passed to
     * unserialize() and the hash set to the returned array.
     *
     * @param string $data (compressed) serialzed hash data.
     * @param boolean $compression Decides, if the data is
     * uncompressed before unserialisation of the data.
     *
     * @return boolean true, if successful otherwise false.
     *
     * @access public
     */
    function unserialize($data, $compression = true)
    {
        if ($compression) {
            $data = gzuncompress($data);
        }

        if (false === $data) {
            $this->_errorStack->push(TEXT_TEXHYPHEN_WORDCACHE_ERROR,
                                     TEXT_TEXHYPHEN_WORDCACHE_ERROR_STR,
                                     array(),
                                     'Couldn\'t uncompress serialized the hash data');
            return false;
        }

        $this->_hash = unserialize($data);
        if (false === $this->_hash) {
            $this->_hash = array();
            $this->_errorStack->push(TEXT_TEXHYPHEN_WORDCACHE_ERROR,
                                     TEXT_TEXHYPHEN_WORDCACHE_ERROR_STR,
                                     array(),
                                     'Couldn\'t unserialize the hash data');
            return false;
        }

        return true;
    } // end of function unserialize

} // end of class Text_TeXHyphen_WordCache_SimpleHash
