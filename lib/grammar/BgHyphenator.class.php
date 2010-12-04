<?php
require_once dirname(__FILE__) . '/../vendor/Text_TeXHyphen/Text/TeXHyphen.php';
require_once dirname(__FILE__) . '/../vendor/Text_TeXHyphen/Text/TeXHyphen/PatternDB.php';
require_once dirname(__FILE__) . '/../vendor/Text_TeXHyphen/Text/TeXHyphen/WordCache.php';

class BgHyphenator
{
	private
		$hyphenator = null,
		$delimiter  = '-';


	public function __construct()
	{
		$this->constructHyphenator();
	}


	public function setDelimiter($delimiter)
	{
		$this->delimiter = $delimiter;
	}


	public function getSyllables($word)
	{
		if (empty($word) || $word == '—' || strpos($word, ' ') !== false) {
			return $word;
		}

		$syls = $this->hyphenator->getSyllables($this->hyphenEncode($word));

		// check for incorrect hyphenation: a leading syllable of one letter only
		if (strlen($syls[0]) == 1 && count($syls) > 1) {
			$syls[1] = $syls[0] . $syls[1];
			unset($syls[0]);
		}

		$hyphenWord = implode($this->delimiter, $syls);
		// remove double hyphens
		$hyphenWord = str_replace($this->delimiter . $this->delimiter, $this->delimiter, $hyphenWord);

		return $this->hyphenDecode($hyphenWord);
	}


	private function hyphenEncode($word)
	{
		return iconv('UTF-8', 'windows-1251', $word);
	}

	private function hyphenDecode($word)
	{
		return iconv('windows-1251', 'UTF-8', $word);
	}


	private function constructHyphenator()
	{
		// create a pattern source by loading a pattern file
		$patternArr = file(dirname(__FILE__) . '/../vendor/Text_TeXHyphen/hyph_bg_BG.tex');

		// remove header line with source information
		array_shift($patternArr);

		$options = array('mode' => 'build', 'data' => &$patternArr, 'onlyKeys' => true);
		$patternDB = Text_TeXHyphen_PatternDB::factory('objecthash', $options);

		$wordCache = Text_TeXHyphen_WordCache::factory('simplehash');

		$this->hyphenator = Text_TeXHyphen::factory($patternDB, array('wordcache' => $wordCache));
	}
}
